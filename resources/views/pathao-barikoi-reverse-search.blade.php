<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Address Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="relative w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4 text-gray-700 text-center">🏡 Select Your Address</h3>

        <!-- 🔍 Customer Full Address -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Customer Full Address</label>
            <textarea id="customer-full-address" class="w-full border border-gray-300 focus:ring-2 focus:ring-[#017e84] rounded-md p-3 shadow-sm resize-none"
                      placeholder="Enter complete address..." required></textarea>
        </div>

        <!-- 📌 Smart Dropdown -->
        <div class="mb-4 relative">
            <label class="block text-gray-700 font-medium mb-2">Select Address <span class="text-red-500">*</span></label>
            <input type="text" id="selected-address" class="w-full border border-gray-300 focus:ring-2 focus:ring-[#017e84] rounded-md p-3 shadow-sm"
                   placeholder="Search area, block, road, or business..." oninput="searchAddress(this.value)" autocomplete="off" required>
            
            <!-- 🔽 Smart Dropdown -->
            <ul id="suggestions" class="hidden absolute w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto mt-2 z-50 transition-all">
            </ul>
        </div>

        <!-- 🛠 Submit Button -->
        <button onclick="submitForm()" class="w-full bg-[#017e84] text-white py-3 rounded-md text-lg font-semibold transition hover:bg-[#015e64]">
            🚀 Submit Address
        </button>
    </div>

    <!-- 🛠 JavaScript for Barikoi API Calls -->
    <script>
const apiKey = "MjI4NzpXNTY1TTNNM0NR"; // Replace with your actual API Key

async function searchAddress(query) {
    if (query.length < 2) {
        document.getElementById("suggestions").classList.add("hidden");
        return;
    }

    console.log("🔍 Searching Barikoi (Areas & Businesses):", query);

    try {
        let response = await fetch(`https://barikoi.xyz/v1/api/search/autocomplete/${apiKey}/place?q=${encodeURIComponent(query)}`);
        let data = await response.json();
        let suggestionsBox = document.getElementById("suggestions");
        suggestionsBox.innerHTML = "";
        suggestionsBox.classList.remove("hidden");

        if (data.places && data.places.length > 0) {
            let uniqueAddresses = [];
            let seen = new Set();

            data.places.forEach(place => {
                let formattedArea = `${place.area}, ${place.city || "N/A"}`;
                let formattedBusiness = place.address ? `${place.address}, ${place.area || "N/A"}, ${place.city || "N/A"}` : null;

                let normalizedArea = formattedArea.toLowerCase().replace(/[^a-z0-9]/g, ""); 
                if (!seen.has(normalizedArea)) {
                    seen.add(normalizedArea);
                    uniqueAddresses.push({ type: "area", value: formattedArea });
                }

                if (formattedBusiness) {
                    let normalizedBusiness = formattedBusiness.toLowerCase().replace(/[^a-z0-9]/g, ""); 
                    if (!seen.has(normalizedBusiness)) {
                        seen.add(normalizedBusiness);
                        uniqueAddresses.push({ type: "business", value: formattedBusiness });
                    }
                }
            });

            uniqueAddresses.forEach(entry => {
                let li = document.createElement("li");
                li.textContent = entry.value;
                li.className = "px-4 py-3 cursor-pointer transition duration-200 ease-in-out border-b last:border-b-0 text-gray-800 text-sm font-medium";

                // ✅ Lighter Hover Effect
                li.onmouseover = () => li.style.backgroundColor = "#E6F4F1"; // Soft Light Teal  
                li.onmouseout = () => li.style.backgroundColor = "transparent"; // Default  

                li.onclick = function () {
                    document.getElementById("selected-address").value = entry.value;
                    closeDropdown();
                };
                suggestionsBox.appendChild(li);
            });

        } else {
            suggestionsBox.innerHTML = "<li class='p-3 text-gray-500 text-center'>No results found</li>";
        }
    } catch (error) {
        console.error("❌ Error fetching Barikoi data:", error);
    }
}

function closeDropdown() {
    let suggestionsBox = document.getElementById("suggestions");
    suggestionsBox.classList.add("hidden");
    suggestionsBox.innerHTML = "";
}

document.addEventListener("click", function(event) {
    let searchInput = document.getElementById("selected-address");
    let suggestionsBox = document.getElementById("suggestions");

    if (!searchInput.contains(event.target) && !suggestionsBox.contains(event.target)) {
        closeDropdown();
    }
});

function submitForm() {
    let customerAddress = document.getElementById("customer-full-address").value.trim();
    let selectedAddress = document.getElementById("selected-address").value.trim();

    if (!selectedAddress) {
        alert("❌ You must select an address from the dropdown.");
        return;
    }

    alert("🎉 Address Submitted Successfully!");
}
    </script>

</body>
</html>
