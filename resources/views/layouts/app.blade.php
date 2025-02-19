<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS SaaS</title>

    <!-- Global Styles -->
    @if(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.reset') || request()->routeIs('password.confirm') || request()->routeIs('verification.notice'))
        @vite(['resources/css/auth.css', 'resources/js/auth.js'])
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-md">
        <ul class="flex space-x-6 p-4">
            <li><a href="{{ url('/') }}" class="text-gray-700 dark:text-gray-300 hover:underline">Home</a></li>
            
            @auth
                <li><a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:underline">Dashboard</a></li>

                @role('admin')
                    <li><a href="{{ route('admin.users') }}" class="text-gray-700 dark:text-gray-300 hover:underline">Manage Users</a></li>
                    <li><a href="{{ route('reports') }}" class="text-gray-700 dark:text-gray-300 hover:underline">View Reports</a></li>
                @endrole

                @role('manager')
                    <li><a href="{{ route('sales') }}" class="text-gray-700 dark:text-gray-300 hover:underline">Process Sales</a></li>
                @endrole

                @role('cashier')
                    <li><a href="{{ route('pos') }}" class="text-gray-700 dark:text-gray-300 hover:underline">POS System</a></li>
                @endrole

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:underline">Login</a></li>
                <li><a href="{{ route('register') }}" class="text-gray-700 dark:text-gray-300 hover:underline">Register</a></li>
            @endauth
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto mt-8 p-4">
        @yield('content')
    </main>

</body>
</html>
