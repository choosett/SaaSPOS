<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }} - Auth</title>

    <!-- Load Auth-specific CSS -->
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>
