<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - POS SaaS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Material Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


    
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-blue-900 text-white p-4 flex justify-between items-center shadow-md">
                <h1 class="text-lg font-bold"></h1>
                
            </header>

            <!-- Page Content -->
            <main class="p-6 overflow-y-auto flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>

</body>
</html>
