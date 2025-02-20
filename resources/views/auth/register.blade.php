<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Registration</title>

    <!-- Include Tailwind CSS & Custom JS -->
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</head>
<body class="dark">
    <button id="mode-toggle" class="mode-toggle">Switch Mode</button>
    <div class="auth-container">
        <h1 class="pos-title">GoCreative CRM</h1>
        <p class="pos-slogan">Most Advanced Courier Enabled POS and Inventory Solution.</p>

        <!-- Step Indicators -->
        <div class="step-indicators">
            <div class="step-indicator active" id="step-1-btn">1. Business</div>
            <div class="step-indicator" id="step-2-btn">2. Business Settings</div>
            <div class="step-indicator" id="step-3-btn">3. Owner</div>
        </div>

        <form id="registration-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <!-- Step 1: Business Details -->
            <section class="step-content active" id="step-1">
                <h2 class="text-xl font-bold mb-4">Business Details</h2>
                <div class="auth-row">
                    <div class="auth-column">
                        <label>Business Name:* <input type="text" class="auth-input" name="business_name" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Start Date:* <input type="date" class="auth-input" name="start_date" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Currency:* 
                            <select name="currency" class="auth-input">
                                <option value="BDT" selected>BDT (Bangladeshi Taka)</option>
                            </select>
                        </label>
                    </div>
                    <div class="auth-column">
                        <label>Upload Logo: <input type="file" class="auth-input" name="logo"></label>
                    </div>
                    <div class="auth-column">
                        <label>Website: <input type="text" class="auth-input" name="website"></label>
                    </div>
                    <div class="auth-column">
                        <label>Business Contact Number:* <input type="tel" class="auth-input" name="business_contact" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Alternate Contact Number: <input type="tel" class="auth-input" name="alternate_contact"></label>
                    </div>
                    <div class="auth-column">
                        <label>Country:* <input type="text" class="auth-input" value="Bangladesh" disabled></label>
                    </div>
                    <div class="auth-column">
                        <label>District:* 
                            <select name="district" class="auth-input">
                                <option value="">Select District</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chattogram">Chattogram</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
                            </select>
                        </label>
                    </div>
                    <div class="auth-column">
                        <label>Business Address:* <input type="text" class="auth-input" name="business_address" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Zip Code:* <input type="text" class="auth-input" name="zip_code" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Time Zone:* <input type="text" class="auth-input" value="BST +6" disabled></label>
                    </div>
                </div>
                <div class="auth-buttons">
                    <button type="button" class="next-btn auth-button">Next</button>
                </div>
            </section>

            <!-- Step 2: Business Settings -->
            <section class="step-content hidden" id="step-2">
                <h2 class="text-xl font-bold mb-4">Business Settings</h2>
                <div class="auth-row">
                    <div class="auth-column">
                        <label>BIN Number: <input type="text" class="auth-input" name="bin_number"></label>
                    </div>
                    <div class="auth-column">
                        <label>DBID Number: <input type="text" class="auth-input" name="dbid_number"></label>
                    </div>
                    <div class="auth-column">
                        <label>Financial Year Start Month:* <input type="month" class="auth-input" name="financial_year" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Stock Accounting Method:* 
                            <select name="stock_method" class="auth-input">
                                <option value="FIFO">FIFO</option>
                                <option value="LIFO">LIFO</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="auth-buttons">
                    <button type="button" class="prev-btn auth-button-secondary">Previous</button>
                    <button type="button" class="next-btn auth-button">Next</button>
                </div>
            </section>

            <!-- Step 3: Owner Details -->
            <section class="step-content hidden" id="step-3">
                <h2 class="text-xl font-bold mb-4">Owner Details</h2>
                <div class="auth-row">
                    <div class="auth-column">
                        <label>First Name:* <input type="text" class="auth-input" name="first_name" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Last Name: <input type="text" class="auth-input" name="last_name"></label>
                    </div>
                    <div class="auth-column">
                        <label>Username:* <input type="text" class="auth-input" name="username" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Email:* <input type="email" class="auth-input" name="email" required></label>
                    </div>
                   <div class="auth-column">
                        <label>Password:* <input type="password" class="auth-input" name="password" required></label>
                    </div>
                    <div class="auth-column">
                        <label>Confirm Password:* <input type="password" class="auth-input" name="password_confirmation" required></label>
                    </div>

                </div>
                <div class="auth-buttons">
                    <button type="button" class="prev-btn auth-button-secondary">Previous</button>
                    <button type="submit" class="auth-button">Register Business</button>
                </div>
            </section>
        </form>
        <p class="mt-6 text-sm">Already have an account? <a href="/login" class="auth-link">Sign in</a></p>
    </div>

    @if ($errors->any())
    <div class="text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>
