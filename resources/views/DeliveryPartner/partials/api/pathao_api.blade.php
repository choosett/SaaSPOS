<!-- ✅ Pathao API Modal -->
<div id="pathaoApiModal" class="modal-overlay hidden">
    <div class="modal-content">
        <!-- Close Button -->
        <button id="closePathaoApiModal" class="close-btn">
            <i class="fas fa-times"></i>
        </button>

        <!-- Modal Header -->
        <div class="modal-header">
            <img src="{{ asset('deliverypartner/pathao.svg') }}" alt="Pathao Logo" class="modal-icon">
            <h3 class="modal-title">@lang('Pathao API Integration')</h3>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <h4 class="modal-subtitle">@lang('Integration Info')</h4>

            <div class="space-y-4">
                <!-- ✅ Username -->
                <div>
                    <label class="label">@lang('Username')</label>
                    <input type="email" class="input-box" id="username" placeholder="Enter Username" required>
                </div>

                <!-- ✅ Password (Eye Icon Removed) -->
                <div>
                    <label class="label">@lang('Password')</label>
                    <input type="password" id="passwordField" class="input-box" placeholder="Enter Password" required>
                </div>

                <!-- ✅ Client ID -->
                <div>
                    <label class="label">@lang('Client ID')</label>
                    <input type="text" class="input-box" id="clientId" placeholder="Enter Client ID" required>
                </div>

                <!-- ✅ Client Secret (Eye Icon Removed) -->
                <div>
                    <label class="label">@lang('Client Secret')</label>
                    <input type="password" id="clientSecretField" class="input-box" placeholder="Enter Client Secret" required>
                </div>
            </div>

            <!-- ✅ Message Display -->
            <p id="pathaoApiMessage" class="log-message hidden"></p>

            <!-- ✅ Debugging Logs -->
            <pre id="debugLogs" class="log-box hidden"></pre>
        </div>

        <!-- ✅ Modal Footer -->
        <div class="modal-footer">
            <button id="cancelPathaoApi" class="btn-cancel">
                <i class="fas fa-times"></i> @lang('Cancel')
            </button>
            <button class="btn-save" id="savePathaoApi">
                <i class="fas fa-save"></i> @lang('Save')
            </button>
        </div>
    </div>
</div>

<!-- ✅ Include Pathao JavaScript via Vite -->
@vite(['resources/js/Modules/Deliverypartner/Pathao.js'])
