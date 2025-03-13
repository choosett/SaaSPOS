<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Check Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
    <div class="bg-white p-6 shadow-md rounded-lg w-full max-w-2xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Delivery Success Rate</h2>
            <button onclick="refreshData()" class="bg-[#003d99] text-white px-3 py-2 rounded-md hover:bg-[#002866] transition">
                🔄 Refresh
            </button>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div id="progress-bar" class="h-full bg-[#003d99] transition-all duration-500" style="width: {{ $apiData['courierData']['summary']['success_ratio'] ?? 0 }}%;"></div>
        </div>
        <p id="success-rate" class="text-green-600 text-lg font-bold mt-2">
            {{ $apiData['courierData']['summary']['success_ratio'] ?? 0 }}%
        </p>

        <!-- Last Updated -->
        <p id="last-updated" class="text-gray-500 text-sm mt-2">
            Updated at {{ now()->format('M j, Y g:i A') }} by Wasik Mahim Talukder
        </p>

        <!-- Data Table -->
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Courier</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Total</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-blue-500">Delivered</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-red-500">Undelivered</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Confidence</th>
                </tr>
            </thead>
            <tbody id="courier-data">
                @foreach($apiData['courierData'] as $courier => $data)
                    @if($courier != 'summary')
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 font-semibold">{{ ucfirst($courier) }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $data['total_parcel'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-blue-500 font-semibold">{{ $data['success_parcel'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-red-500 font-semibold">{{ $data['cancelled_parcel'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $data['success_ratio'] }}%</td>
                        </tr>
                    @endif
                @endforeach
                <tr class="bg-gray-200 font-semibold">
                    <td class="border border-gray-300 px-4 py-2">Total</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $apiData['courierData']['summary']['total_parcel'] }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-blue-500">{{ $apiData['courierData']['summary']['success_parcel'] }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-red-500">{{ $apiData['courierData']['summary']['cancelled_parcel'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $apiData['courierData']['summary']['success_ratio'] }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- JavaScript for Refresh -->
    <script>
        function refreshData() {
            fetch("{{ url('/courier-check') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update progress bar
                document.getElementById('progress-bar').style.width = data.courierData.summary.success_ratio + "%";
                document.getElementById('success-rate').innerText = data.courierData.summary.success_ratio + "%";

                // Update last updated timestamp
                document.getElementById('last-updated').innerText = "Updated at " + new Date().toLocaleString() + " by Wasik Mahim Talukder";

                // Update table content
                let tableBody = document.getElementById('courier-data');
                tableBody.innerHTML = "";
                Object.entries(data.courierData).forEach(([courier, values]) => {
                    if (courier !== "summary") {
                        tableBody.innerHTML += `
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-semibold">${courier.toUpperCase()}</td>
                                <td class="border border-gray-300 px-4 py-2">${values.total_parcel}</td>
                                <td class="border border-gray-300 px-4 py-2 text-blue-500 font-semibold">${values.success_parcel}</td>
                                <td class="border border-gray-300 px-4 py-2 text-red-500 font-semibold">${values.cancelled_parcel}</td>
                                <td class="border border-gray-300 px-4 py-2">${values.success_ratio}%</td>
                            </tr>
                        `;
                    }
                });

                // Update total row
                tableBody.innerHTML += `
                    <tr class="bg-gray-200 font-semibold">
                        <td class="border border-gray-300 px-4 py-2">Total</td>
                        <td class="border border-gray-300 px-4 py-2">${data.courierData.summary.total_parcel}</td>
                        <td class="border border-gray-300 px-4 py-2 text-blue-500">${data.courierData.summary.success_parcel}</td>
                        <td class="border border-gray-300 px-4 py-2 text-red-500">${data.courierData.summary.cancelled_parcel}</td>
                        <td class="border border-gray-300 px-4 py-2">${data.courierData.summary.success_ratio}%</td>
                    </tr>
                `;
            })
            .catch(error => console.error("Error refreshing data:", error));
        }
    </script>
</body>
</html>
