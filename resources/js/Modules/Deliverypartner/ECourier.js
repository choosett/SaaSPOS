import { 
    showMessage, 
    enableOutsideClickClose, 
    enableModalCloseButtons, 
    sendApiRequest, 
    closeModal, 
    toggleVisibility 
} from "./Index.js";

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.getElementById("saveECourierApi");
    const eyeIcons = document.querySelectorAll(".password-toggle");
    const messageBox = document.getElementById("ecourierApiMessage");

    if (!messageBox) {
        console.error("🚨 ERROR: Message box #ecourierApiMessage NOT FOUND in DOM!");
    } else {
        console.log("✅ Message box found:", messageBox);
    }

    if (!saveButton) {
        console.error("❌ Save button NOT found in DOM!");
    } else {
        console.log("✔ Save button found!");

        saveButton.addEventListener("click", async function () {
            console.log("✔ Save button clicked!");

            let userId = document.getElementById("ecourierUserId").value.trim();
            let apiKey = document.getElementById("ecourierApiKey").value.trim();
            let apiSecret = document.getElementById("ecourierApiSecret").value.trim();
            let businessId = document.getElementById("businessId").value.trim();

            if (!userId || !apiKey || !apiSecret) {
                showMessage('<i class="fas fa-exclamation-circle"></i> All fields are required!', "error", "ecourierApiMessage");
                return;
            }

            sendApiRequest(
                "/api/ecourier/check-and-store-credentials", // ✅ Fixed API endpoint
                { business_id: businessId, user_id: userId, api_key: apiKey, api_secret: apiSecret },
                "ecourierApiMessage",
                () => setTimeout(() => closeModal("ecourierApiModal"), 1500) // ✅ Fixed Modal ID
            );
        });
    }

    // ✅ Enable Modal Close Buttons (Cancel & Close Icon)
    enableModalCloseButtons("ecourierApiModal", "closeECourierModal", "cancelECourierApi");

    // ✅ Enable Outside Click to Close
    enableOutsideClickClose("ecourierApiModal");

    // ✅ Enable Password Toggle Visibility for all eye icons
    if (eyeIcons.length > 0) {
        console.log(`👀 Found ${eyeIcons.length} password toggles`);
        eyeIcons.forEach(icon => {
            icon.addEventListener("click", function () {
                let fieldId = this.dataset.field;
                let iconId = this.dataset.icon;
                console.log(`🔄 Toggling visibility for: ${fieldId}, Icon: ${iconId}`);
                toggleVisibility(fieldId, iconId);
            });
        });
    } else {
        console.warn("⚠ No password toggles found!");
    }
});
