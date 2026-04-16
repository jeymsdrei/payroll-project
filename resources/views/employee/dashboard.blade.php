@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Welcome, {{ $user->name }}</h1>
    <p>This portal shows your payroll history, payslips, and tax deductions.</p>
</div>
<div class="card">
    <h2>Salary summary</h2>
    <p><strong>Base salary:</strong> ${{ number_format($user->salary_base, 2) }}</p>
    <p><strong>Hourly rate:</strong> ${{ number_format($user->hourly_rate, 2) }}</p>
    <p><strong>Overtime rate:</strong> ${{ number_format($user->overtime_rate, 2) }}</p>
    <p><strong>Tax rate:</strong> {{ number_format($user->tax_rate * 100, 2) }}%</p>
</div>
<div class="card">
    <h2>Payroll history</h2>
    <table>
        <thead>
            <tr><th>Period</th><th>Gross</th><th>Tax</th><th>Net</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->period_start }} - {{ $payroll->period_end }}</td>
                    <td>${{ number_format($payroll->gross_pay, 2) }}</td>
                    <td>${{ number_format($payroll->tax_amount, 2) }}</td>
                    <td>${{ number_format($payroll->net_pay, 2) }}</td>
                    <td><a class="button button-secondary" href="{{ route('employee.payslip', $payroll) }}">View payslip</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No payroll records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $payrolls->links() }}
</div>
@endsection
