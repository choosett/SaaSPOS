<!-- ✅ RedX API Modal -->
<div id="redxApiModal" class="modal-overlay hidden">
    <div class="modal-content">
        <!-- Close Button -->
        <button id="closeRedxModal" class="close-btn">
            <i class="fas fa-times"></i>
        </button>

        <!-- Modal Header -->
        <div class="modal-header">
            <img src="{{ asset('deliverypartner/redx.svg') }}" alt="RedX Logo" class="courier-icon">
            <h3 class="modal-title">@lang('RedX API Integration')</h3>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <h4 class="modal-subtitle">@lang('Integration Info')</h4>

            <!-- ✅ Business ID (Hidden, Auto-filled) -->
            <input type="hidden" id="businessId" value="{{ auth()->user()->business_id ?? '' }}">

            <!-- ✅ Access Token (Eye Icon Removed) -->
            <div class="relative">
                <label class="label">@lang('Access Token')</label>
                <input type="password" id="accessTokenField" class="input-box" placeholder="Enter Access Token">
            </div>

            <!-- ✅ Message Display -->
            <p id="redxApiMessage" class="hidden log-message"></p>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button id="cancelRedxApi" class="btn-cancel">
                <i class="fas fa-times"></i> @lang('Cancel')
            </button>
            <button class="btn-save" id="saveRedxApi">
                <i class="fas fa-save"></i> @lang('Save')
            </button>
        </div>
    </div>
</div>

<!-- ✅ Load JavaScript -->
@vite('resources/js/Modules/Deliverypartner/Redx.js')
