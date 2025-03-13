<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Check</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
    <div class="bg-white p-6 shadow-md rounded-lg w-full max-w-md">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Enter Phone Number</h2>

        <form method="POST" action="{{ url('/courier-check') }}">
            @csrf
            <input type="text" name="phone" required 
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter Phone Number">

            <button type="submit"
                class="mt-4 w-full bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 transition">
                Check Courier
            </button>
        </form>
    </div>
</body>
</html>
