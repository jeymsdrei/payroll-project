<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\Deduction;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
        $employees = User::where('role', User::ROLE_EMPLOYEE)->paginate(20);

        return view('admin.employees.index', compact('employees'));
    }

    public function show(User $user)
    {
        abort_unless($user->isEmployee(), 404);

        return view('admin.employees.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->isEmployee(), 404);

        $data = $request->validate([
            'salary_base' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'overtime_rate' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'between:0,1'],
        ]);

        $user->update(array_filter($data, fn ($value) => $value !== null));

        return back()->with('success', 'Employee salary configuration updated.');
    }

    public function storeBenefit(Request $request, User $user)
    {
        abort_unless($user->isEmployee(), 404);

        $data = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['required', 'date'],
        ]);

        Benefit::create(array_merge($data, ['user_id' => $user->id]));

        return back()->with('success', 'Benefit added successfully.');
    }

    public function storeDeduction(Request $request, User $user)
    {
        abort_unless($user->isEmployee(), 404);

        $data = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['required', 'date'],
        ]);

        Deduction::create(array_merge($data, ['user_id' => $user->id]));

        return back()->with('success', 'Deduction added successfully.');
    }
}
