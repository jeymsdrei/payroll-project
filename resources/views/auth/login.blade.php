@extends('layouts.app')

@section('content')
<div class="card" style="max-width:500px; margin: 0 auto;">
    <h1>Login</h1>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button class="button">Login</button>
    </form>
</div>
@endsection
