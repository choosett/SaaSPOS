document.addEventListener("DOMContentLoaded", function () {
    console.log("Auth Page Loaded");

    // Auto-focus first input field
    const firstInput = document.querySelector(".auth-input");
    if (firstInput) firstInput.focus();

    // Password Show/Hide Functionality
    function setupPasswordToggle() {
        document.querySelectorAll(".password-wrapper").forEach(wrapper => {
            const passwordInput = wrapper.querySelector(".auth-input[type='password']");
            const toggleIcon = wrapper.querySelector(".toggle-password");

            if (passwordInput && toggleIcon) {
                toggleIcon.addEventListener("click", function () {
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        toggleIcon.innerHTML = "🙈"; // Change icon to indicate it's visible
                    } else {
                        passwordInput.type = "password";
                        toggleIcon.innerHTML = "👁️"; // Change icon back
                    }
                });
            }
        });
    }

    setupPasswordToggle(); // Call the function to apply functionality

    // Multi-step form navigation
    const steps = document.querySelectorAll(".step-content");
    const stepIndicators = document.querySelectorAll(".step-indicator");
    const nextButtons = document.querySelectorAll(".next-btn");
    const prevButtons = document.querySelectorAll(".prev-btn");
    const form = document.getElementById("registration-form");
    let currentStep = 0;

    function showStep(step) {
        if (!steps[step]) return;

        steps.forEach((s, index) => {
            s.classList.toggle("hidden", index !== step);
            stepIndicators[index].classList.toggle("active", index === step);
        });

        document.querySelector(".auth-container").scrollIntoView({ behavior: "smooth" });

        currentStep = step;
    }

    nextButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                if (currentStep < steps.length - 1) {
                    showStep(++currentStep);
                }
            }
        });
    });

    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (currentStep > 0) {
                showStep(--currentStep);
            }
        });
    });

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

    form.addEventListener("submit", function (event) {
        if (!validateStep(currentStep)) {
            event.preventDefault();
        }
    });

    showStep(currentStep);

    function enableAutoDatePicker() {
        const dateInputs = document.querySelectorAll('input[type="date"], input[type="month"]');

        dateInputs.forEach((input) => {
            input.addEventListener("focus", () => {
                if (input.showPicker) {
                    input.showPicker();
                }
            });
        });
    }

    enableAutoDatePicker();

    // Dark Mode / Day Mode Toggle
    const modeToggle = document.getElementById("mode-toggle");
    const body = document.body;

    function toggleMode() {
        body.classList.toggle("dark");
        body.classList.toggle("light");

        localStorage.setItem("theme", body.classList.contains("dark") ? "dark" : "light");
    }

    if (modeToggle) {
        modeToggle.addEventListener("click", toggleMode);

        if (localStorage.getItem("theme") === "light") {
            body.classList.remove("dark");
            body.classList.add("light");
        }
    }
});
