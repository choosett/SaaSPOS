// ✅ Import Dependencies
import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery';

// ✅ Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

$(document).ready(function () {
    console.log("✅ jQuery Loaded:", typeof jQuery !== "undefined");

    // ==========================================
    // ✅ SIDEBAR TOGGLE FUNCTIONALITY (Mobile Fix)
    // ==========================================
    function toggleSidebar() {
        const sidebar = $("#sidebar");
        const mainContent = $("#mainContent");
        const overlay = $("#overlay");
        const toggleIcon = $("#toggleIcon");

        sidebar.toggleClass("hidden block");

        // ✅ Mobile: Keep Dashboard Full Width & Show Overlay
        if (window.innerWidth < 768) {
            if (sidebar.hasClass("block")) {
                mainContent.css("width", "100%");
                overlay.removeClass("hidden"); // Show overlay
            } else {
                overlay.addClass("hidden"); // Hide overlay
            }
        }

        // ✅ Change Icon Based on Sidebar State
        toggleIcon.text(sidebar.hasClass("hidden") ? "menu" : "menu_open");
    }

    // ✅ Attach Click Event for Sidebar Toggle
    $("#toggleSidebar").on("click", function (event) {
        event.stopPropagation();
        toggleSidebar();
    });

    // ✅ Click Outside to Close Sidebar (Mobile Only)
    $("#overlay").on("click", function () {
        $("#sidebar").addClass("hidden").removeClass("block");
        $(this).addClass("hidden");
    });

    // ✅ Ensure Sidebar is Hidden on Mobile Initially
    function checkScreenSize() {
        if (window.innerWidth < 768) {
            $("#sidebar").addClass("hidden").removeClass("block");
            $("#mainContent").css("width", "100%");
            $("#overlay").addClass("hidden");
        } else {
            $("#sidebar").removeClass("hidden").addClass("block");
            $("#mainContent").css("width", "calc(100% - 16rem)"); // Adjust for sidebar width
        }
    }
    checkScreenSize();
    window.addEventListener("resize", checkScreenSize);

    // ==========================================
    // ✅ SUBMENU EXPAND/COLLAPSE (Smooth scaleY Animation)
    // ==========================================
    
    // ✅ Initial State (Submenus Hidden with scaleY)
    $(".submenu").css({
        "transform": "scaleY(0)",
        "transform-origin": "top",
        "transition": "transform 0.3s ease-in-out",
        "display": "none"
    });

    // ✅ Submenu Click Function
    $("#sidebar-menu").on("click", "li > a.has-arrow", function (event) {
        event.preventDefault();
        let submenu = $(this).next(".submenu");

        if (submenu.length) {
            console.log("🔹 Submenu Clicked:", $(this).text());

            let isOpen = submenu.hasClass("open");

            // ✅ Close all other submenus before opening a new one
            $(".submenu.open").not(submenu).removeClass("open").css("transform", "scaleY(0)").slideUp(300);

            // ✅ Toggle submenu state smoothly
            if (!isOpen) {
                submenu.addClass("open").css("transform", "scaleY(1)").slideDown(300);
            } else {
                submenu.removeClass("open").css("transform", "scaleY(0)").slideUp(300);
            }
        }
    });

    console.log("🎯 Sidebar & Submenu (ScaleY) Initialized!");
});
