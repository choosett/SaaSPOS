import { showMessage, enableOutsideClickClose, enableModalCloseButtons, sendApiRequest, closeModal, toggleVisibility } from './Index.js';

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.getElementById("saveSteadfastApi");
    const eyeIcons = document.querySelectorAll(".password-toggle");

    if (saveButton) {
        console.log("✔ Save button found!");

        saveButton.addEventListener("click", async function () {
            console.log("✔ Save button clicked!");

            let businessId = document.getElementById("businessId").value.trim();
            let apiKey = document.getElementById("apiKeyField").value.trim();
            let apiSecret = document.getElementById("apiSecretField").value.trim();

            if (!apiKey || !apiSecret) {
                showMessage('<i class="fas fa-exclamation-circle"></i> All fields are required!', "error", "steadfastApiMessage");
                return;
            }

            sendApiRequest("/api/steadfast/store-credentials",
                { business_id: businessId, api_key: apiKey, api_secret: apiSecret },
                "steadfastApiMessage",
                () => setTimeout(() => closeModal("steadfastApiModal"), 2000)
            );
        });
    }

    // ✅ Enable Modal Close Buttons (Cancel & Close Icon)
    enableModalCloseButtons("steadfastApiModal", "closeSteadfastModal", "cancelSteadfastApi");

    // ✅ Enable Outside Click to Close
    enableOutsideClickClose("steadfastApiModal");

    // ✅ Enable Password Toggle Visibility for all eye icons
    if (eyeIcons.length > 0) {
        eyeIcons.forEach(icon => {
            icon.addEventListener("click", function () {
                let fieldId = this.getAttribute("data-field");
                let iconId = this.getAttribute("data-icon");
                toggleVisibility(fieldId, iconId);
            });
        });
    }
});
