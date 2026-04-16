@extends('layouts.app')

@section('content')
<div class="card" style="max-width:500px; margin: 0 auto;">
    <h1>Register</h1>
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="form-group">
            <label for="name">Full name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
        </div>
        <button class="button">Create account</button>
    </form>
</div>
@endsection
