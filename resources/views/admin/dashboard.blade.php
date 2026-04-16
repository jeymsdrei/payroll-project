@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Admin Dashboard</h1>
    <div class="grid grid-3">
        <div class="card">
            <h3>Total employees</h3>
            <p style="font-size:2rem; margin:0.5rem 0;">{{ $employees }}</p>
        </div>
        <div class="card">
            <h3>Total gross payroll</h3>
            <p style="font-size:2rem; margin:0.5rem 0;">${{ number_format($totalGross, 2) }}</p>
        </div>
        <div class="card">
            <h3>Total taxes withheld</h3>
            <p style="font-size:2rem; margin:0.5rem 0;">${{ number_format($totalTax, 2) }}</p>
        </div>
        <div class="card">
            <h3>Total net payouts</h3>
            <p style="font-size:2rem; margin:0.5rem 0;">${{ number_format($totalNet, 2) }}</p>
        </div>
    </div>
</div>
@endsection
