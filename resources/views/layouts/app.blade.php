<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS SaaS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            
            @auth
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

                @role('admin')
                    <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
                    <li><a href="{{ route('reports') }}">View Reports</a></li>
                @endrole

                @role('manager')
                    <li><a href="{{ route('sales') }}">Process Sales</a></li>
                @endrole

                @role('cashier')
                    <li><a href="{{ route('pos') }}">POS System</a></li>
                @endrole

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>


