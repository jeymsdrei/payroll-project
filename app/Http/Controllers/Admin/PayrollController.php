<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use App\Services\PayrollCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            abort_unless(auth()->user()->isAdmin(), 403);
            return $next($request);
        });
    }

    public function index()
    {
        $payrolls = Payroll::with('user')->latest()->paginate(15);

        return view('admin.payrolls.index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        return view('admin.payrolls.show', compact('payroll'));
    }

    public function exportCsv(): \Illuminate\Http\StreamedResponse
    {
        $payrolls = Payroll::with('user')->orderBy('period_start')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payroll-report.csv"',
        ];

        $callback = function () use ($payrolls) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Employee', 'Email', 'Period Start', 'Period End', 'Gross Pay', 'Tax', 'Deductions', 'Benefits', 'Net Pay']);

            foreach ($payrolls as $payroll) {
                fputcsv($handle, [
                    $payroll->user->name,
                    $payroll->user->email,
                    $payroll->period_start,
                    $payroll->period_end,
                    number_format($payroll->gross_pay, 2),
                    number_format($payroll->tax_amount, 2),
                    number_format($payroll->deductions_amount, 2),
                    number_format($payroll->benefits_amount, 2),
                    number_format($payroll->net_pay, 2),
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, 'payroll-report.csv', $headers);
    }

    public function store(Request $request, PayrollCalculator $calculator)
    {
        $data = $request->validate([
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $periodStart = Carbon::parse($data['period_start']);
        $periodEnd = Carbon::parse($data['period_end']);

        $query = User::where('role', User::ROLE_EMPLOYEE);
        if (! empty($data['user_id'])) {
            $query->where('id', $data['user_id']);
        }

        $employees = $query->get();
        foreach ($employees as $employee) {
            $calculator->createPayroll($employee, $periodStart, $periodEnd);
        }

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll generated successfully.');
    }
}
