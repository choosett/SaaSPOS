import Alpine from 'alpinejs';
import $ from 'jquery';

// ✅ Ensure Alpine.js is globally available
window.Alpine = Alpine;
Alpine.start();

// ✅ Ensure jQuery 3.7.1 is used
window.$ = window.jQuery = $;

$(document).ready(function () {
    console.log("✅ supplier.js Loaded with jQuery:", $.fn.jquery);

    // ✅ Ensure CSRF Token is included in AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ========================================================
    // ✅ DROPDOWN MENU FUNCTIONALITY FOR ACTION BUTTON
    // ========================================================
    window.toggleDropdown = function (button, event) {
        event.stopPropagation(); 
        let dropdown = $("#dropdown-menu");

        if (window.openDropdown && window.openDropdown !== button) {
            dropdown.addClass("hidden");
        }

        $("body").append(dropdown);
        let rect = button.getBoundingClientRect();
        dropdown.css({
            left: `${rect.left}px`,
            top: `${rect.bottom + window.scrollY}px`
        }).toggleClass("hidden");

        window.openDropdown = dropdown.hasClass("hidden") ? null : button;
    };

    // ✅ Close dropdown when clicking outside
    $(document).click(function (event) {
        if (!$(event.target).closest("#dropdown-menu, button").length) {
            $("#dropdown-menu").addClass("hidden");
            window.openDropdown = null;
        }
    });

    // ========================================================
    // ✅ PAGINATION FUNCTIONALITY FOR TABLE
    // ========================================================
    let rowsPerPage = parseInt(localStorage.getItem("supplierEntriesPerPage")) || 10;
    let table = $("#suppliers-table");
    let rows = table.find("tbody tr");
    let totalEntries = rows.length;
    let currentPage = 1;
    let totalPages = Math.ceil(totalEntries / rowsPerPage);

    function showPage(page) {
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        rows.hide().slice(start, end).show();

        $("#current-entries").text(start + 1);
        $("#max-entries").text(Math.min(end, totalEntries));
        $("#total-entries").text(totalEntries);

        $("#prevPage").prop("disabled", page === 1);
        $("#nextPage").prop("disabled", page === totalPages);
    }

    showPage(currentPage);

    $("#prevPage").click(function () {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    $("#nextPage").click(function () {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    $("#entriesSelect").on("change", function () {
        rowsPerPage = parseInt($(this).val());
        localStorage.setItem("supplierEntriesPerPage", rowsPerPage);
        showPage(1);
    });

    // ========================================================
    // ✅ FILTER FUNCTIONALITY (Purchase Due, Return, Balances)
    // ========================================================
    function applyFilters() {
        let showNoDataMessage = true;

        rows.each(function () {
            let purchaseDue = parseFloat($(this).find("td:nth-child(8)").text().trim().replace(/[৳,]/g, '')) || 0;
            let purchaseReturn = parseFloat($(this).find("td:nth-child(9)").text().trim().replace(/[৳,]/g, '')) || 0;
            let advanceBalance = parseFloat($(this).find("td:nth-child(6)").text().trim().replace(/[৳,]/g, '')) || 0;
            let openingBalance = parseFloat($(this).find("td:nth-child(5)").text().trim().replace(/[৳,]/g, '')) || 0;

            let showRow = true;

            if ($("#purchase_due").is(":checked") && purchaseDue <= 0) showRow = false;
            if ($("#purchase_return").is(":checked") && purchaseReturn <= 0) showRow = false;
            if ($("#advance_balance").is(":checked") && advanceBalance <= 0) showRow = false;
            if ($("#opening_balance").is(":checked") && openingBalance <= 0) showRow = false;

            if (showRow) {
                $(this).show();
                showNoDataMessage = false;
            } else {
                $(this).hide();
            }
        });

        if (showNoDataMessage) {
            if ($("#noDataRow").length === 0) {
                $("#suppliers-table tbody").append(
                    `<tr id="noDataRow"><td colspan="9" class="text-center text-gray-500 py-3">No data available in table</td></tr>`
                );
            }
        } else {
            $("#noDataRow").remove();
        }
    }

    // ✅ Event Listeners for Filters
    $("#purchase_due, #purchase_return, #advance_balance, #opening_balance").change(function () {
        applyFilters();
    });

    // ========================================================
    // ✅ LIVE SEARCH FUNCTIONALITY
    // ========================================================
    $("#searchInput").on("keyup", function () {
        let searchValue = $(this).val().toLowerCase();
        rows.each(function () {
            let rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.includes(searchValue));
        });
    });

    // ========================================================
    // ✅ EXPORT FUNCTIONS
    // ========================================================
    $("#exportExcel").click(function () {
        let table = document.getElementById("suppliers-table");
        if (!table) {
            alert("No table found to export!");
            return;
        }
        let wb = XLSX.utils.table_to_book(table, { sheet: "Suppliers" });
        XLSX.writeFile(wb, "suppliers.xlsx");
    });

    $("#exportPrint").click(function () {
        window.print();
    });

    $("#exportPDF").click(function () {
        let element = document.getElementById("suppliers-table");
        if (!element) {
            alert("No table found to export!");
            return;
        }
        html2pdf().from(element).save("suppliers.pdf");
    });

    // ========================================================
    // ✅ FILTER SECTION TOGGLE FUNCTION
    // ========================================================
    window.toggleFilters = function () {
        let filterSection = $("#filterSection");
        if (filterSection.hasClass("opacity-0")) {
            filterSection.css("max-height", filterSection.prop("scrollHeight") + "px").removeClass("opacity-0");
        } else {
            filterSection.css("max-height", "0px");
            setTimeout(() => {
                filterSection.addClass("opacity-0");
            }, 300);
        }
    };

    // ========================================================
    // ✅ ASSIGNED TO FILTER FUNCTIONALITY
    // ========================================================
    $("#assignedToFilter").on("change", function () {
        let selectedUser = $(this).val().toLowerCase();
        let visibleRows = 0;

        $("#noDataRow").remove();

        rows.each(function () {
            let assignedUser = $(this).find(".assigned-user").text().trim().toLowerCase();

            if (selectedUser === "" || assignedUser === selectedUser) {
                $(this).show();
                visibleRows++;
            } else {
                $(this).hide();
            }
        });

        if (visibleRows === 0) {
            $("#suppliers-table tbody").append(
                `<tr id="noDataRow"><td colspan="10" class="text-center text-gray-500 py-4">No data available</td></tr>`
            );
        }
    });

});
