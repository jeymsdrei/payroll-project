<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management System</title>
    <style>
        body { font-family: ui-sans-serif, system-ui, sans-serif; margin: 0; background: #f4f6f8; color: #111827; }
        header { background: #111827; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #d1d5db; margin-right: 1rem; text-decoration: none; }
        nav a:hover { color: white; }
        main { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 0.75rem; box-shadow: 0 4px 20px rgba(15,23,42,.08); padding: 1.5rem; margin-bottom: 1.5rem; }
        .grid { display: grid; gap: 1rem; }
        .grid-3 { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        .button { background: #2563eb; color: white; border: none; padding: 0.75rem 1.25rem; border-radius: 0.5rem; cursor: pointer; }
        .button:hover { background: #1d4ed8; }
        .button-secondary { background: #e5e7eb; color: #111827; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.85rem 0.75rem; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { color: #374151; font-weight: 600; }
        .alert { padding: 1rem; border-radius: 0.75rem; background: #ecfdf5; color: #065f46; margin-bottom: 1rem; }
        .error { padding: 1rem; border-radius: 0.75rem; background: #fee2e2; color: #991b1b; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.35rem; font-size: 0.95rem; color: #374151; }
        input, select, textarea { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
    </style>
</head>
<body>
    <header>
        <div>
            <a href="{{ route('home') }}" style="color:white;font-weight:bold;text-decoration:none;">Payroll System</a>
        </div>
        <nav>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    <a href="{{ route('admin.employees.index') }}">Employees</a>
                    <a href="{{ route('admin.payrolls.index') }}">Payrolls</a>
                @else
                    <a href="{{ route('employee.dashboard') }}">Dashboard</a>
                @endif
                <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="error">
                <strong>There was a problem:</strong>
                <ul style="margin:0.75rem 0 0 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
