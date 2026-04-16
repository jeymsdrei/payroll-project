@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Manage {{ $user->name }}</h1>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <form method="POST" action="{{ route('admin.employees.update', $user) }}" class="card">
        @csrf
        <h2>Salary configuration</h2>
        <div class="form-group">
            <label for="salary_base">Base salary</label>
            <input id="salary_base" name="salary_base" type="number" step="0.01" value="{{ old('salary_base', $user->salary_base) }}">
        </div>
        <div class="form-group">
            <label for="hourly_rate">Hourly rate</label>
            <input id="hourly_rate" name="hourly_rate" type="number" step="0.01" value="{{ old('hourly_rate', $user->hourly_rate) }}">
        </div>
        <div class="form-group">
            <label for="overtime_rate">Overtime rate</label>
            <input id="overtime_rate" name="overtime_rate" type="number" step="0.01" value="{{ old('overtime_rate', $user->overtime_rate) }}">
        </div>
        <div class="form-group">
            <label for="tax_rate">Tax rate</label>
            <input id="tax_rate" name="tax_rate" type="number" step="0.01" value="{{ old('tax_rate', $user->tax_rate) ?? 0.15 }}">
        </div>
        <button class="button">Update employee</button>
    </form>

    <div class="card">
        <h2>Benefits</h2>
        <form method="POST" action="{{ route('admin.employees.benefits.store', $user) }}">
            @csrf
            <div class="form-group">
                <label for="description">Benefit description</label>
                <input id="description" name="description" type="text" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input id="amount" name="amount" type="number" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="effective_from">Effective from</label>
                <input id="effective_from" name="effective_from" type="date" required>
            </div>
            <button class="button">Add Benefit</button>
        </form>

        <table>
            <thead>
                <tr><th>Description</th><th>Amount</th><th>Effective from</th></tr>
            </thead>
            <tbody>
                @foreach($user->benefits as $benefit)
                    <tr>
                        <td>{{ $benefit->description }}</td>
                        <td>${{ number_format($benefit->amount, 2) }}</td>
                        <td>{{ $benefit->effective_from->toDateString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Deductions</h2>
        <form method="POST" action="{{ route('admin.employees.deductions.store', $user) }}">
            @csrf
            <div class="form-group">
                <label for="description">Deduction description</label>
                <input id="description" name="description" type="text" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input id="amount" name="amount" type="number" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="effective_from">Effective from</label>
                <input id="effective_from" name="effective_from" type="date" required>
            </div>
            <button class="button">Add Deduction</button>
        </form>

        <table>
            <thead>
                <tr><th>Description</th><th>Amount</th><th>Effective from</th></tr>
            </thead>
            <tbody>
                @foreach($user->deductions as $deduction)
                    <tr>
                        <td>{{ $deduction->description }}</td>
                        <td>${{ number_format($deduction->amount, 2) }}</td>
                        <td>{{ $deduction->effective_from->toDateString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
