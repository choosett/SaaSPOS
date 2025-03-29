<!-- ✅ E-Courier API Modal -->
<div id="ecourierApiModal" class="modal-overlay hidden"> <!-- 🔥 Fixed ID -->
    <div class="modal-content">
        <!-- Close Button -->
        <button id="closeECourierModal" class="close-btn">
            <i class="fas fa-times"></i>
        </button>

        <!-- Modal Header -->
        <div class="modal-header">
            <img src="{{ asset('deliverypartner/ecourier.svg') }}" alt="E-Courier Logo" class="modal-icon">
            <h3 class="modal-title">@lang('E-Courier API Integration')</h3>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <h4 class="modal-subtitle">@lang('Enter API Credentials')</h4>

            <div class="space-y-4">
                <!-- ✅ Business ID (Hidden, Auto-filled) -->
                <input type="hidden" id="businessId" value="{{ auth()->user()->business_id ?? '' }}">

                <!-- ✅ User ID -->
                <div>
                    <label class="label">@lang('User ID')</label>
                    <input type="text" id="ecourierUserId" class="input-box" placeholder="Enter User ID">
                </div>

                <!-- ✅ API Key -->
                <div>
                    <label class="label">@lang('API Key')</label>
                    <input type="password" id="ecourierApiKey" class="input-box" placeholder="Enter API Key">
                </div>

                <!-- ✅ API Secret -->
                <div>
                    <label class="label">@lang('API Secret')</label>
                    <input type="password" id="ecourierApiSecret" class="input-box" placeholder="Enter API Secret">
                </div>

                <!-- ✅ Message Display -->
                <p id="ecourierApiMessage" class="hidden log-message"></p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button id="cancelECourierApi" class="btn-cancel">
                <i class="fas fa-times"></i> @lang('Cancel')
            </button>
            <button class="btn-save" id="saveECourierApi">
                <i class="fas fa-save"></i> @lang('Save')
            </button>
        </div>
    </div>
</div>


<!-- ✅ Load JavaScript -->
@vite('resources/js/Modules/Deliverypartner/ECourier.js')
