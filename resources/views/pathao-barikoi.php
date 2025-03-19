<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pathao & Barikoi Location Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-3">Select Location</h3>

        <!-- City Dropdown -->
        <label class="block text-sm font-medium">City</label>
        <select id="city-select" class="w-full px-4 py-2 border rounded-md" onchange="fetchZones(this.value)">
            <option value="">Select City</option>
            @foreach ($cities as $city)
                <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
            @endforeach
        </select>

        <!-- Zone Dropdown -->
        <label class="block text-sm font-medium mt-3">Zone</label>
        <select id="zone-select" class="w-full px-4 py-2 border rounded-md" onchange="fetchAreas(this.value)">
            <option value="">Select Zone</option>
        </select>

        <!-- Area Dropdown -->
        <label class="block text-sm font-medium mt-3">Area</label>
        <select id="area-select" class="w-full px-4 py-2 border rounded-md">
            <option value="">Select Area</option>
        </select>

        <!-- Search Box -->
        <label class="block text-sm font-medium mt-3">Search Location</label>
        <input type="text" id="barikoi-search" class="w-full px-4 py-2 border rounded-md" placeholder="Type a location..." oninput="searchBarikoi(this.value)">

        <!-- Suggestions -->
        <ul id="suggestions" class="bg-white border mt-2 p-2 rounded-md shadow hidden"></ul>

        <!-- Selected Location Details -->
        <div id="selected-location" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-md hidden">
            <h4 class="text-lg font-semibold mb-2">Selected Location Details:</h4>
            <pre id="selected-output" class="bg-gray-200 p-2 rounded text-sm overflow-x-auto w-full max-h-60"></pre>
        </div>
    </div>

    <script>
        const accessToken = "{{ $accessToken ?? '' }}";
        const baseUrl = "https://courier-api-sandbox.pathao.com/aladdin/api/v1";
        const apiKey = "MjI4NzpXNTY1TTNNM0NR";

        async function fetchCities() {
    try {
        let response = await fetch("/api/pathao/cities");
        let data = await response.json();

        console.log("Cities Loaded:", data);

        let citySelect = document.getElementById("city-select");
        citySelect.innerHTML = "<option value=''>Select City</option>";
        data.data.data.forEach(city => {
            citySelect.innerHTML += `<option value="${city.city_id}">${city.city_name}</option>`;
        });
    } catch (error) {
        console.error("Error fetching Pathao Cities:", error);
    }
}

async function fetchZones(cityId) {
    if (!cityId) return;
    try {
        let response = await fetch(`/api/pathao/zones/${cityId}`);
        let data = await response.json();

        console.log(`Zones for City ${cityId}:`, data);

        let zoneSelect = document.getElementById("zone-select");
        zoneSelect.innerHTML = "<option value=''>Select Zone</option>";
        data.data.data.forEach(zone => {
            zoneSelect.innerHTML += `<option value="${zone.zone_id}">${zone.zone_name}</option>`;
        });
    } catch (error) {
        console.error(`Error fetching Zones for City ${cityId}:`, error);
    }
}

async function fetchAreas(zoneId) {
    if (!zoneId) return;
    try {
        let response = await fetch(`/api/pathao/areas/${zoneId}`);
        let data = await response.json();

        console.log(`Areas for Zone ${zoneId}:`, data);

        let areaSelect = document.getElementById("area-select");
        areaSelect.innerHTML = "<option value=''>Select Area</option>";
        data.data.data.forEach(area => {
            areaSelect.innerHTML += `<option value="${area.area_id}">${area.area_name}</option>`;
        });
    } catch (error) {
        console.error(`Error fetching Areas for Zone ${zoneId}:`, error);
    }
}


        async function searchBarikoi(query) {
            if (query.length < 2) return;
            let response = await fetch(`https://barikoi.xyz/v2/api/search/autocomplete/place?api_key=${apiKey}&q=${query}`);
            let data = await response.json();
            let suggestionsBox = document.getElementById("suggestions");
            suggestionsBox.innerHTML = "";
            suggestionsBox.classList.remove("hidden");

            data.places.forEach(place => {
                let li = document.createElement("li");
                li.textContent = `${place.city} > ${place.area} > ${place.address}`;
                li.className = "p-2 hover:bg-gray-100 cursor-pointer";
                li.onclick = function () {
                    document.getElementById("barikoi-search").value = li.textContent;
                    fetchReverseGeocode(place.latitude, place.longitude);
                    suggestionsBox.classList.add("hidden");
                };
                suggestionsBox.appendChild(li);
            });
        }

        async function fetchReverseGeocode(lat, lon) {
            let response = await fetch(`https://barikoi.xyz/v2/api/search/reverse/geocode?api_key=${apiKey}&longitude=${lon}&latitude=${lat}`);
            let data = await response.json();

            if (data.places.length > 0) {
                document.getElementById("selected-output").textContent = JSON.stringify(data.places[0], null, 4);
                document.getElementById("selected-location").classList.remove("hidden");
            }
        }
    </script>

</body>
</html>
