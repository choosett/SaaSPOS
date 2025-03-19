<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - POS SaaS</title>

    <!-- ✅ Load Vite Assets (CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/Deliverypartner.css'])

    @vite([
    'resources/js/Modules/Deliverypartner/Pathao.js',
    'resources/js/Modules/Deliverypartner/ECourier.js',
    'resources/js/Modules/Deliverypartner/RedX.js',
    'resources/js/Modules/Deliverypartner/Steadfast.js',
    'resources/js/Modules/Deliverypartner/Index.js' 
])


    <!-- ✅ Google Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ✅ Pass CSRF Token & Routes to JavaScript -->
    <script>
        window.csrfToken = "{{ csrf_token() }}";
        window.userIndexRoute = "{{ route('users.index') }}";
    </script>

    <!-- ✅ Ensure jQuery is already loaded -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- ✅ Required JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="{{ asset('js/supplier.js') }}"></script>

    <!-- ✅ Toastr Notifications (CSS & JS) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- ✅ Alpine.js (for interactive UI elements) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- ✅ Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;500&display=swap">

    <!-- ✅ Table Font Styling -->
    <style>
        th {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }
        td {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }
    </style>

    <!-- ✅ Toastr Configuration (Show Success Messages) -->
    <script>
        $(document).ready(function () {
            @if(session('success'))
                toastr.success("{{ session('success') }}", "Success", {
                    positionClass: "toast-top-right",
                    timeOut: 3000,
                    progressBar: true,
                    closeButton: true,
                });
            @endif
        });
    </script>

    <!-- ✅ Sidebar & Layout Styling -->
    <style>
       

    </style>

</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 sidebar-open"> <!-- ✅ Sidebar Open by Default -->

    <div class="flex h-screen">
        <!-- ✅ Sidebar Component -->
        @include('components.sidebar')

        <!-- ✅ Main Content -->
        <div id="mainContent" class="flex-1 flex flex-col">
            
            <!-- ✅ Header with Sidebar Toggle Button -->
            <header class="bg-blue-900 text-white p-4 flex items-center shadow-md relative">
                <!-- ✅ Sidebar Toggle Button -->
                <button id="toggleSidebar" class="absolute left-[260px] md:left-[260px] top-1/2 transform -translate-y-1/2 text-white p-2 rounded-md transition-all duration-300">
                    <span id="toggleIcon" class="material-icons">menu</span>
                </button>
                <h1 class="ml-16 md:ml-20 text-lg font-bold">Zyro</h1>
            </header>

            <!-- ✅ Page Content (Dynamic Content Section) -->
            <main class="p-6 overflow-y-auto flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- ✅ Sidebar Toggle Script -->
    <script>
        $(document).ready(function () {
            console.log("✅ Sidebar Toggle Loaded!");

            // ✅ Sidebar Toggle Function
            function toggleSidebar() {
                $("body").toggleClass("sidebar-open sidebar-closed");

                // ✅ Adjust Sidebar Toggle Button Position
                if ($("body").hasClass("sidebar-closed")) {
                    $("#toggleSidebar").css("left", "15px"); // Move to left when sidebar is closed
                } else {
                    $("#toggleSidebar").css("left", "0"); // Move next to sidebar when open
                }
            }

            // ✅ Attach Click Event for Sidebar Toggle
            $("#toggleSidebar").on("click", function (event) {
                event.stopPropagation();
                toggleSidebar();
            });

            // ✅ Ensure Sidebar is Open on Desktop, Closed on Mobile Initially
            function checkScreenSize() {
                if ($(window).width() < 768) {
                    $("body").removeClass("sidebar-open").addClass("sidebar-closed");
                    $("#toggleSidebar").css("left", "15px"); // Adjust button for mobile
                } else {
                    $("body").removeClass("sidebar-closed").addClass("sidebar-open");
                    $("#toggleSidebar").css("left", "0px"); // Adjust button for desktop
                }
            }

            checkScreenSize();
            $(window).on("resize", checkScreenSize);
        });
    </script>

    <!-- ✅ Placeholder for Additional Page Scripts -->
    @yield('scripts')

</body>
</html>
