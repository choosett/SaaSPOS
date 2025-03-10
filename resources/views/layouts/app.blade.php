<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - POS SaaS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ✅ Google Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script>
        window.csrfToken = "{{ csrf_token() }}";
        window.userIndexRoute = "{{ route('users.index') }}";
    </script>

   <!-- ✅ Ensure jQuery is already loaded -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- ✅ Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- ✅ Toastr JS (Ensure it loads after jQuery) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




<!-- ✅ Toastr Configuration -->
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



    <style>
        /* ✅ Sidebar Defaults */
        #sidebar {
            transform: translateX(0); /* ✅ Sidebar Open Initially */
            transition: transform 0.3s ease-in-out;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 50;
            width: 260px;
            background: #f4f4f5;
        }

        /* ✅ Hide Sidebar on Mobile by Default */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
        }

        /* ✅ When Sidebar is Opened */
        .sidebar-open #sidebar {
            transform: translateX(0);
        }

        /* ✅ Main Content Adjusts Dynamically */
        #mainContent {
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        /* ✅ Desktop Mode */
        @media (min-width: 769px) {
            .sidebar-open #mainContent {
                margin-left: 260px; /* ✅ Sidebar Open */
                width: calc(100% - 260px);
            }

            .sidebar-closed #mainContent {
                margin-left: 0; /* ✅ Sidebar Closed */
                width: 100%;
            }
        }

        /* ✅ Mobile Mode - Always Full Width */
        @media (max-width: 768px) {
            #mainContent {
                width: 100%;
            }
        }

        /* ✅ Toggle Button Adjustments */
        #toggleSidebar {
            position: absolute;
            left: 260px; /* ✅ Default position when sidebar is open */
            transition: left 0.3s ease-in-out;
        }

        /* ✅ Sidebar Closed - Toggle Moves to Default */
        .sidebar-closed #toggleSidebar {
            left: 15px !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 sidebar-open"> <!-- ✅ Sidebar Open by Default -->

    <div class="flex h-screen">
        <!-- ✅ Sidebar -->
        @include('components.sidebar')

        <!-- ✅ Main Content -->
        <div id="mainContent" class="flex-1 flex flex-col">
            <!-- ✅ Header with Toggle Button -->
            <header class="bg-blue-900 text-white p-4 flex items-center shadow-md relative">
                <!-- ✅ Sidebar Toggle Button -->
                <button id="toggleSidebar" class="absolute left-[260px] md:left-[260px] top-1/2 transform -translate-y-1/2 text-white p-2 rounded-md transition-all duration-300">
                    <span id="toggleIcon" class="material-icons">menu</span>
                </button>
                <h1 class="ml-16 md:ml-20 text-lg font-bold">Perfex</h1>
            </header>

            <!-- ✅ Page Content -->
            <main class="p-6 overflow-y-auto flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- ✅ Sidebar & Toggle Script -->
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

    @yield('scripts')

</body>
</html>
