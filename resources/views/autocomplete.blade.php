<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Autocomplete</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="relative w-full max-w-lg mx-auto">
        <!-- Address Input Field -->
        <input type="text" id="addressInput" placeholder="Enter address"
            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Dropdown for Address Suggestions -->
        <ul id="suggestions"
            class="absolute w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 hidden max-h-96 overflow-auto">
        </ul>
    </div>

    <script>
        let autocomplete;

        function initAutocomplete() {
            console.log("✅ initAutocomplete() called"); // Debugging log

            const input = document.getElementById("addressInput");

            if (!input) {
                console.error("❌ Input element not found!");
                return;
            }

            // ✅ Uses Google Maps JavaScript API for Autocomplete
            autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['geocode'], // Adjust to ['establishment'] for businesses
                componentRestrictions: { country: "BD" }, // Restrict to Bangladesh
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                console.log("✅ Selected Place:", place);

                if (!place.geometry) {
                    console.error("❌ No details available for input:", place.name);
                    return;
                }

                // Display the formatted address
                input.value = place.formatted_address;
            });

            console.log("✅ Autocomplete initialized successfully!");
        }
    </script>

    <!-- ✅ Google Maps JavaScript API should load AFTER defining `initAutocomplete` -->
    <script async 
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&callback=initAutocomplete">
</script>


</body>
</html>
