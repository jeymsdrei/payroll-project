@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Payroll Management</h1>
    <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <form method="POST" action="{{ route('admin.payrolls.store') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end; flex:1; min-width:320px;">
            @csrf
            <div style="flex:1; min-width:220px;">
                <label for="period_start">Period start</label>
                <input id="period_start" name="period_start" type="date" required>
            </div>
        <div style="flex:1; min-width:220px;">
            <label for="period_end">Period end</label>
            <input id="period_end" name="period_end" type="date" required>
        </div>
        <div style="flex:1; min-width:220px;">
            <label for="user_id">Employee (optional)</label>
            <select id="user_id" name="user_id">
                <option value="">All employees</option>
                @foreach(App\Models\User::where('role', App\Models\User::ROLE_EMPLOYEE)->get() as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->email }})</option>
                @endforeach
            </select>
        </div>
        <button class="button">Generate payroll</button>
    </form>
    <div style="align-self:flex-end;">
        <a class="button button-secondary" href="{{ route('admin.payrolls.export') }}">Export payroll CSV</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Period</th>
                <th>Gross pay</th>
                <th>Net pay</th>
                <th>Tax</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->user->name }}</td>
                    <td>{{ $payroll->period_start }} - {{ $payroll->period_end }}</td>
                    <td>${{ number_format($payroll->gross_pay, 2) }}</td>
                    <td>${{ number_format($payroll->net_pay, 2) }}</td>
                    <td>${{ number_format($payroll->tax_amount, 2) }}</td>
                    <td><a class="button button-secondary" href="{{ route('admin.payrolls.show', $payroll) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No payroll records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $payrolls->links() }}
</div>
@endsection
