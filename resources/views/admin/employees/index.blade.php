@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Employees</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Base salary</th>
                <th>Hourly rate</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>${{ number_format($employee->salary_base, 2) }}</td>
                    <td>${{ number_format($employee->hourly_rate, 2) }}</td>
                    <td><a class="button button-secondary" href="{{ route('admin.employees.show', $employee) }}">Manage</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No employees found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $employees->links() }}
</div>
@endsection
