<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            abort_unless(auth()->user()->isEmployee(), 403);
            return $next($request);
        });
    }

    public function index()
    {
        $user = auth()->user();
        $payrolls = $user->payrolls()->latest()->paginate(10);

        return view('employee.dashboard', compact('user', 'payrolls'));
    }

    public function showPayslip(Payroll $payroll)
    {
        abort_unless(auth()->id() === $payroll->user_id, 403);

        return view('employee.payslip', compact('payroll'));
    }
}
