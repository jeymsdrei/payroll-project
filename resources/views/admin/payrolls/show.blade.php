@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Payroll Detail</h1>
    <p><strong>Employee:</strong> {{ $payroll->user->name }} ({{ $payroll->user->email }})</p>
    <p><strong>Period:</strong> {{ $payroll->period_start }} - {{ $payroll->period_end }}</p>
    <p><strong>Gross pay:</strong> ${{ number_format($payroll->gross_pay, 2) }}</p>
    <p><strong>Tax:</strong> ${{ number_format($payroll->tax_amount, 2) }}</p>
    <p><strong>Deductions:</strong> ${{ number_format($payroll->deductions_amount, 2) }}</p>
    <p><strong>Benefits:</strong> ${{ number_format($payroll->benefits_amount, 2) }}</p>
    <p><strong>Net pay:</strong> ${{ number_format($payroll->net_pay, 2) }}</p>
    <div class="card">
        <h2>Payslip Details</h2>
        <ul>
            @foreach($payroll->details as $label => $value)
                <li><strong>{{ ucwords(str_replace('_', ' ', $label)) }}:</strong> {{ is_numeric($value) ? ('$'.number_format($value, 2)) : $value }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
