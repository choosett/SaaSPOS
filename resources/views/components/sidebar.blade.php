<!-- SIDEBAR CONTAINER -->
<div id="sidebar" 
     class="w-64 h-full fixed top-0 left-0 shadow-lg overflow-y-auto bg-white z-50 
            transform transition-all duration-500 ease-in-out text-[#4B5565] text-sm"
     style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    
    <!-- USER INFO SECTION -->
    <div class="p-4 text-center border-b">
        <div class="flex flex-col items-center bg-gray-100 p-3 rounded-lg">
            <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" 
                 alt="User Avatar" class="rounded-full w-12 h-12">
            <h2 class="mt-2 font-bold text-black">Laurel Padberg</h2>
            <p class="text-gray-500 text-xs">admin@test.com</p>
        </div>
    </div>

    <!-- SIDEBAR MENU -->
    <nav>
        <ul>
            <!-- Dashboard -->
            <li>
                <a href="#" class="flex items-center p-3 bg-gray-100 font-bold hover:bg-gray-200 rounded-md mx-2">
                    <span class="material-icons mr-3">dashboard</span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            <!-- User Management (Dropdown) -->
            <li>
                <button id="userDropdown" class="w-full flex items-center justify-between p-3 hover:bg-gray-200 rounded-md mx-2">
                    <span class="flex items-center">
                        <span class="material-icons mr-3">person</span>
                        <span class="sidebar-text">User Management</span>
                    </span>
                    <span id="chevronIcon" class="material-icons transition-transform duration-500">expand_more</span>
                </button>

                <!-- Dropdown Menu -->
                <ul id="userMenu" class="ml-6 max-h-0 overflow-hidden transition-all duration-700 ease-in-out border-l-2 border-gray-300">
                    <li><a href="#" class="block p-2 hover:bg-gray-100">Users</a></li>
                    <li><a href="#" class="block p-2 hover:bg-gray-100">Roles</a></li>
                    <li><a href="#" class="block p-2 hover:bg-gray-100">Sales Commission Agents</a></li>
                </ul>
            </li>

            <!-- Contacts -->
            <li><a href="#" class="flex items-center p-3 hover:bg-gray-200 rounded-md mx-2"><span class="material-icons mr-3">contacts</span> <span class="sidebar-text">Contacts</span></a></li>

            <!-- Products -->
            <li><a href="#" class="flex items-center p-3 hover:bg-gray-200 rounded-md mx-2"><span class="material-icons mr-3">inventory</span> <span class="sidebar-text">Products</span></a></li>

            <!-- Purchases -->
            <li><a href="#" class="flex items-center p-3 hover:bg-gray-200 rounded-md mx-2"><span class="material-icons mr-3">shopping_cart</span> <span class="sidebar-text">Purchases</span></a></li>

            <!-- Sales -->
            <li><a href="#" class="flex items-center p-3 hover:bg-gray-200 rounded-md mx-2"><span class="material-icons mr-3">sell</span> <span class="sidebar-text">Sell</span></a></li>
        </ul>
    </nav>
</div>

<!-- SIDEBAR TOGGLE BUTTON (Moves Right When Closed, Moves Left When Opened) -->
<button id="toggleSidebar" class="p-2 bg-[#0F317D] text-white fixed top-4 left-[270px] z-50 transition-all duration-500 ease-in-out">
    <span class="material-icons">menu_open</span>  <!-- Sidebar Close/Open Icon -->
</button>

<!-- JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const userDropdown = document.getElementById('userDropdown');
        const userMenu = document.getElementById('userMenu');
        const chevronIcon = document.getElementById('chevronIcon');

        // Sidebar Toggle Function (Moves Button Position)
        toggleSidebar.addEventListener('click', function () {
            if (sidebar.classList.contains('-translate-x-full')) {
                // Open Sidebar
                sidebar.classList.remove('-translate-x-full');
                toggleSidebar.innerHTML = '<span class="material-icons">menu_open</span>';
                toggleSidebar.classList.remove('left-4');       
                toggleSidebar.classList.add('left-[270px]');   
            } else {
                // Close Sidebar
                sidebar.classList.add('-translate-x-full');
                toggleSidebar.innerHTML = '<span class="material-icons">menu</span>';
                toggleSidebar.classList.remove('left-[270px]'); 
                toggleSidebar.classList.add('left-4');         
            }
        });

        // Dropdown Animation (Collapses When Sidebar is Closed)
        userDropdown.addEventListener('click', function () {
            if (userMenu.classList.contains('max-h-0')) {
                userMenu.classList.remove('max-h-0');
                userMenu.classList.add('max-h-40', 'py-2');
                chevronIcon.innerText = 'expand_less';
            } else {
                userMenu.classList.remove('max-h-40', 'py-2');
                userMenu.classList.add('max-h-0');
                chevronIcon.innerText = 'expand_more';
            }
        });
    });
</script>
