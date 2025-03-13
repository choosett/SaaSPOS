document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ calendar.js is loaded correctly!");  // Debugging message

    // Check if Pikaday is available
    if (typeof Pikaday === "undefined") {
        console.error("❌ Pikaday is not loaded! Check pikaday.js path.");
        return;
    }

    // Get input field
    const calendarInput = document.getElementById("calendar");

    if (!calendarInput) {
        console.error("❌ Calendar input field not found!");
        return;
    }

    // Initialize Pikaday
    const picker = new Pikaday({
        field: calendarInput,
        format: 'YYYY-MM-DD',
        firstDay: 1,
        showWeekNumber: false,
        onSelect: function(date) {
            console.log(`✅ Selected Date: ${picker.toString()}`); // Debugging output

            // ✅ Ensure the selected date gets brand color
            setTimeout(() => {
                document.querySelectorAll(".pika-day.is-selected").forEach(selected => {
                    selected.style.backgroundColor = "#017e84";  // Apply brand color
                    selected.style.color = "white";  // Ensure text is visible
                    selected.style.fontWeight = "bold";
                    selected.style.borderRadius = "5px";
                    selected.style.border = "2px solid #015a5e";  // Slight contrast
                });
            }, 50);
        }
    });

    console.log("✅ Pikaday initialized successfully!");
});
