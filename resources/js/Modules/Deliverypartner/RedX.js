import { showMessage, enableOutsideClickClose, enableModalCloseButtons, sendApiRequest, closeModal, toggleVisibility } from './Index.js';

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.getElementById("saveRedxApi");
    const eyeIcons = document.querySelectorAll(".password-toggle");

    if (saveButton) {
        console.log("✔ Save button found!");

        saveButton.addEventListener("click", async function () {
            console.log("✔ Save button clicked!");

            let accessToken = document.getElementById("accessTokenField").value.trim();
            let businessId = document.getElementById("businessId").value.trim();

            if (!accessToken) {
                showMessage('<i class="fas fa-exclamation-circle"></i> Access Token is required!', "error", "redxApiMessage");
                return;
            }

            // ✅ Send API Request to Verify & Store Credentials
            sendApiRequest(
                `/api/redx/verify-access-token?access_token=${encodeURIComponent(accessToken)}`,
                { business_id: businessId, access_token: accessToken },
                "redxApiMessage",
                () => setTimeout(() => closeModal("redxApiModal"), 1500)
            );
        });
    }

    // ✅ Enable Modal Close Buttons (Cancel & Close Icon)
    enableModalCloseButtons("redxApiModal", "closeRedxModal", "cancelRedxApi");

    // ✅ Enable Outside Click to Close Modal
    enableOutsideClickClose("redxApiModal");

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
