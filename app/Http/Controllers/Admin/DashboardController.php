<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;

class DashboardController extends Controller
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
        $employees = User::where('role', User::ROLE_EMPLOYEE)->count();
        $totalGross = Payroll::sum('gross_pay');
        $totalTax = Payroll::sum('tax_amount');
        $totalNet = Payroll::sum('net_pay');

        return view('admin.dashboard', compact('employees', 'totalGross', 'totalTax', 'totalNet'));
    }
}
