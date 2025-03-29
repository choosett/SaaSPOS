<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecourier API Credentials</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Ecourier API Credentials</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Courier ID</th>
                    <th>Business ID</th>
                    <th>Courier Name</th>
                    <th>Credentials</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody id="ecourier-data">
                <tr>
                    <td colspan="6" class="text-center">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: "/api/business-data",
                method: "GET",
                headers: {
                    "Authorization": "Bearer {{ auth()->user()->createToken('api-token')->plainTextToken }}"
                },
                success: function (response) {
                    $("#ecourier-data").empty();

                    if (response.data.length === 0) {
                        $("#ecourier-data").append('<tr><td colspan="6" class="text-center">No data found</td></tr>');
                        return;
                    }

                    $.each(response.data, function (index, ecourier) {
                        $("#ecourier-data").append(`
                            <tr>
                                <td>${ecourier.courier_id}</td>
                                <td>${ecourier.business_id}</td>
                                <td>${ecourier.courier_name}</td>
                                <td>${ecourier.credentials}</td>
                                <td>${ecourier.created_at}</td>
                                <td>${ecourier.updated_at}</td>
                            </tr>
                        `);
                    });
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                    $("#ecourier-data").html('<tr><td colspan="6" class="text-center text-danger">Error loading data</td></tr>');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
