<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Admin\PayrollController as AdminPayrollController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'employee.dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('employees', [AdminEmployeeController::class, 'index'])->name('employees.index');
    Route::get('employees/{user}', [AdminEmployeeController::class, 'show'])->name('employees.show');
    Route::post('employees/{user}', [AdminEmployeeController::class, 'update'])->name('employees.update');
    Route::post('employees/{user}/benefits', [AdminEmployeeController::class, 'storeBenefit'])->name('employees.benefits.store');
    Route::post('employees/{user}/deductions', [AdminEmployeeController::class, 'storeDeduction'])->name('employees.deductions.store');

    Route::get('payrolls', [AdminPayrollController::class, 'index'])->name('payrolls.index');
    Route::get('payrolls/export', [AdminPayrollController::class, 'exportCsv'])->name('payrolls.export');
    Route::post('payrolls', [AdminPayrollController::class, 'store'])->name('payrolls.store');
    Route::get('payrolls/{payroll}', [AdminPayrollController::class, 'show'])->name('payrolls.show');
});

Route::get('employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
Route::get('employee/payslips/{payroll}', [EmployeeDashboardController::class, 'showPayslip'])->name('employee.payslip');
