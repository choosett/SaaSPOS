import { showMessage, enableOutsideClickClose, enableModalCloseButtons, sendApiRequest, closeModal, toggleVisibility } from './Index.js';

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.getElementById("savePathaoApi");
    const eyeIcons = document.querySelectorAll(".password-toggle");

    if (saveButton) {
        console.log("✔ Save button found!");

        saveButton.addEventListener("click", async function () {
            console.log("✔ Save button clicked!");

            let clientId = document.getElementById("clientId").value.trim();
            let clientSecret = document.getElementById("clientSecretField").value.trim();
            let username = document.getElementById("username").value.trim();
            let password = document.getElementById("passwordField").value.trim();
            let businessId = document.getElementById("businessId").value.trim();

            if (!clientId || !clientSecret || !username || !password) {
                showMessage('<i class="fas fa-exclamation-circle"></i> All fields are required!', "error", "pathaoApiMessage");
                return;
            }

            sendApiRequest("/api/pathao/store-credentials",
                { client_id: clientId, client_secret: clientSecret, username, password, business_id: businessId },
                "pathaoApiMessage",
                () => setTimeout(() => closeModal("pathaoApiModal"), 1500)
            );
        });
    }

    // ✅ Enable Modal Close Buttons (Cancel & Close Icon)
    enableModalCloseButtons("pathaoApiModal", "closePathaoApiModal", "cancelPathaoApi");

    // ✅ Enable Outside Click to Close
    enableOutsideClickClose("pathaoApiModal");

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
