<!-- ✅ Steadfast API Modal -->
<div id="steadfastApiModal" class="modal-overlay hidden">
    <div class="modal-content">
        <!-- Close Button -->
        <button id="closeSteadfastModal" class="close-btn">
            <i class="fas fa-times"></i>
        </button>

        <!-- Modal Header -->
        <div class="modal-header">
            <img src="{{ asset('deliverypartner/steadfast.svg') }}" alt="Steadfast Logo" class="modal-icon">
            <h3 class="modal-title">@lang('Steadfast API Integration')</h3>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <h4 class="modal-subtitle">@lang('Integration Info')</h4>

            <!-- ✅ Hidden Business ID (Sent via JavaScript) -->
            <input type="hidden" id="businessId" value="{{ auth()->user()->business_id ?? '' }}">

            <!-- ✅ API Key -->
            <div>
                <label class="label">@lang('API Key')</label>
                <input type="text" id="apiKeyField" class="input-box" placeholder="Enter API Key">
            </div>

            <!-- ✅ API Secret (Eye Icon Removed) -->
            <div>
                <label class="label">@lang('API Secret')</label>
                <input type="password" id="apiSecretField" class="input-box" placeholder="Enter API Secret">
            </div>

            <!-- ✅ Log Message Display -->
            <p id="steadfastApiMessage" class="hidden log-message"></p>

            <!-- ✅ Debugging Logs -->
            <pre id="debugLogs" class="log-box hidden"></pre>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button id="cancelSteadfastApi" class="btn-cancel">
                <i class="fas fa-times"></i> @lang('Cancel')
            </button>
            <button class="btn-save" id="saveSteadfastApi">
                <i class="fas fa-save"></i> @lang('Save')
            </button>
        </div>
    </div>
</div>

<!-- ✅ Load JavaScript -->
@vite('resources/js/Modules/Deliverypartner/Steadfast.js')
