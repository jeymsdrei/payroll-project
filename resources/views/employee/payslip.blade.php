@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Payslip for {{ $payroll->period_start }} - {{ $payroll->period_end }}</h1>
    <p><strong>Employee:</strong> {{ $payroll->user->name }}</p>
    <p><strong>Gross pay:</strong> ${{ number_format($payroll->gross_pay, 2) }}</p>
    <p><strong>Tax:</strong> ${{ number_format($payroll->tax_amount, 2) }}</p>
    <p><strong>Deductions:</strong> ${{ number_format($payroll->deductions_amount, 2) }}</p>
    <p><strong>Benefits:</strong> ${{ number_format($payroll->benefits_amount, 2) }}</p>
    <p><strong>Net pay:</strong> ${{ number_format($payroll->net_pay, 2) }}</p>
    <div class="card">
        <h2>Breakdown</h2>
        <ul>
            @foreach($payroll->details as $label => $value)
                <li><strong>{{ ucwords(str_replace('_', ' ', $label)) }}:</strong> {{ is_numeric($value) ? ('$'.number_format($value, 2)) : $value }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
