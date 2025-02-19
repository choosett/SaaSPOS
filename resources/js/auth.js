// resources/js/auth.js

document.addEventListener("DOMContentLoaded", function () {
    console.log("Auth Page Loaded");

    // Auto-focus first input field
    const firstInput = document.querySelector(".auth-input");
    if (firstInput) firstInput.focus();

    // Multi-step form navigation
    const steps = document.querySelectorAll(".step-content");
    const stepIndicators = document.querySelectorAll(".step-indicator");
    const nextButtons = document.querySelectorAll(".next-btn");
    const prevButtons = document.querySelectorAll(".prev-btn");

    let currentStep = 0;

    function showStep(step) {
        // Hide all steps & remove active class
        steps.forEach((s, index) => {
            s.classList.toggle("hidden", index !== step);
            stepIndicators[index].classList.toggle("active", index === step);
        });

        // Scroll to the form smoothly
        document.querySelector(".auth-container").scrollIntoView({ behavior: "smooth" });

        currentStep = step;
    }

    // Handle Next Button Click
    nextButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        });
    });

    // Handle Previous Button Click
    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    // Form validation function
    function validateStep(step) {
        let valid = true;
        const requiredFields = steps[step].querySelectorAll("[required]");

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("border-red-500", "focus:ring-red-500");
                valid = false;
            } else {
                field.classList.remove("border-red-500", "focus:ring-red-500");
            }
        });

        if (!valid) {
            alert("Please fill out all required fields before proceeding.");
        }

        return valid;
    }

    // Handle form submission validation
    const form = document.getElementById("registration-form");
    form.addEventListener("submit", function (event) {
        if (!validateStep(currentStep)) {
            event.preventDefault();
        }
    });

    // Show first step initially
    showStep(currentStep);

    // Automatically open date picker when clicking on "Start Date" or "Financial Year Start Month"
    function enableAutoDatePicker() {
        const dateInputs = document.querySelectorAll('input[type="date"], input[type="month"]');

        dateInputs.forEach((input) => {
            input.addEventListener("focus", () => {
                input.showPicker(); // Open calendar when input is clicked
            });
        });
    }

    // Initialize the date picker function
    enableAutoDatePicker();

    // Dark Mode / Day Mode Toggle
    const modeToggle = document.getElementById("mode-toggle");
    const body = document.body;

    function toggleMode() {
        body.classList.toggle("dark");
        body.classList.toggle("light");

        // Save the preference in localStorage
        localStorage.setItem("theme", body.classList.contains("dark") ? "dark" : "light");
    }

    if (modeToggle) {
        modeToggle.addEventListener("click", toggleMode);

        // Load the saved theme preference from localStorage
        if (localStorage.getItem("theme") === "light") {
            body.classList.remove("dark");
            body.classList.add("light");
        }
    }
});
