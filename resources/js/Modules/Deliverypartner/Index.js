// ✅ Global Utility Functions for API Modals

/**
 * Show a message in the modal (Success/Error/Info)
 * @param {string} message - The message to display
 * @param {string} type - success, error, or info
 * @param {string} messageBoxId - The ID of the message box
 */
export function showMessage(message, type, messageBoxId) {
    let messageBox = document.getElementById(messageBoxId);
    if (!messageBox) {
        console.error(`🚨 Message box not found: ${messageBoxId}`);
        return;
    }

    messageBox.innerHTML = message;
    messageBox.classList.remove("hidden", "success", "error", "info");
    messageBox.classList.add(type);
    messageBox.scrollIntoView({ behavior: "smooth", block: "center" });
}

/**
 * Close the modal when clicking outside the modal box
 * @param {string} modalId - The ID of the modal container
 */
export function enableOutsideClickClose(modalId) {
    let modal = document.getElementById(modalId);
    if (modal) {
        modal.addEventListener("click", function (event) {
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    }
}

/**
 * Close the modal
 * @param {string} modalId - The ID of the modal container
 */
export function closeModal(modalId) {
    let modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add("hidden");
        document.body.style.overflow = "auto";
    }
}

/**
 * Attach event listeners to close buttons (Close & Cancel Buttons)
 * @param {string} modalId - The ID of the modal container
 * @param {string} closeBtnId - The ID of the close button
 * @param {string} cancelBtnId - The ID of the cancel button
 */
export function enableModalCloseButtons(modalId, closeBtnId, cancelBtnId) {
    let closeButton = document.getElementById(closeBtnId);
    let cancelButton = document.getElementById(cancelBtnId);

    if (closeButton) closeButton.addEventListener("click", () => closeModal(modalId));
    if (cancelButton) cancelButton.addEventListener("click", () => closeModal(modalId));
}

/**
 * Toggle password visibility (Show/Hide)
 * @param {Event} event - The click event from the button
 */
export function toggleVisibility(event) {
    let button = event.currentTarget;
    let fieldId = button.getAttribute("data-field");
    let iconId = button.getAttribute("data-icon");

    let field = document.getElementById(fieldId);
    let icon = document.getElementById(iconId);

    if (!field || !icon) {
        console.error(`🚨 Toggle Elements Not Found: ${fieldId}, ${iconId}`);
        return;
    }

    field.type = field.type === "password" ? "text" : "password";
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
}

/**
 * Send API request and handle response
 * @param {string} url - The API URL
 * @param {object} data - The request payload
 * @param {string} messageBoxId - The ID of the message box for status updates
 * @param {function} onSuccess - Callback function on success
 */
export async function sendApiRequest(url, data, messageBoxId, onSuccess) {
    showMessage('<i class="fas fa-spinner fa-spin"></i> Processing request...', "info", messageBoxId);

    try {
        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        let responseData = await response.json();
        console.log("📡 API Response:", responseData);

        if (response.ok) {
            showMessage('<i class="fas fa-check-circle"></i> ' + responseData.message, "success", messageBoxId);
            if (onSuccess) onSuccess();
        } else {
            showMessage('<i class="fas fa-exclamation-triangle"></i> ' + (responseData.message || "Unknown error"), "error", messageBoxId);
        }
    } catch (error) {
        console.error("🚨 API Error:", error);
        showMessage('<i class="fas fa-times-circle"></i> Server error, try again.', "error", messageBoxId);
    }
}
