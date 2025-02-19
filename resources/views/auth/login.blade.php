<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoCreative ERP</title>

    <!-- Include Tailwind CSS & Custom JS -->
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
</head>
<body class="dark flex items-center justify-center min-h-screen">

    <!-- Dark/Light Mode Toggle Button -->
    <button id="mode-toggle" class="mode-toggle absolute top-6 right-6">
        🌙
    </button>

    <div class="auth-container">
        <!-- Welcome Message -->
        <h2 class="text-2xl font-bold mb-2">Welcome Back</h2>
        <p class="text-gray-400 mb-6">Login to your GoCreative ERP</p>

        <form action="/login" method="POST">
            <!-- Username/Email -->
            <div class="auth-column">
                <label class="block text-left text-gray-400 mb-1">Username/Email:</label>
                <input type="text" class="auth-input" name="username" required>
            </div>

            <!-- Password -->
            <div class="auth-column">
                <label class="block text-left text-gray-400 mb-1">Password:</label>
                <div class="relative">
                    <input type="password" class="auth-input" name="password" id="password-field" required>
                    <button type="button" id="toggle-password" class="password-toggle absolute right-4 top-3 text-gray-400">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between items-center mt-4 text-sm">
                <label class="flex items-center text-gray-400">
                    <input type="checkbox" class="mr-2" name="remember">
                    Remember Me
                </label>
                <a href="/forgot-password" class="auth-link">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="auth-button mt-6">Login</button>

            <!-- Register Button -->
            <p class="mt-4 text-sm text-gray-400">
                Don't have an account? <a href="/register" class="auth-link">Register</a>
            </p>
        </form>
    </div>

    <script>
        // Show/Hide Password Feature
        document.getElementById("toggle-password").addEventListener("click", function () {
            const passwordField = document.getElementById("password-field");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                this.innerText = "🙈"; // Change to Hide icon
            } else {
                passwordField.type = "password";
                this.innerText = "👁️"; // Change back to Show icon
            }
        });

        // Dark/Light Mode Toggle
        const modeToggle = document.getElementById("mode-toggle");
        const body = document.body;

        // Load saved mode
        if (localStorage.getItem("theme") === "light") {
            body.classList.remove("dark");
            modeToggle.innerText = "☀️";
        } else {
            body.classList.add("dark");
            modeToggle.innerText = "🌙";
        }

        // Toggle Mode
        modeToggle.addEventListener("click", () => {
            body.classList.toggle("dark");
            if (body.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
                modeToggle.innerText = "🌙";
            } else {
                localStorage.setItem("theme", "light");
                modeToggle.innerText = "☀️";
            }
        });
    </script>

</body>
</html>
