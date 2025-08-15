<div class="tab-pane fade" id="paypal_payment_tab" role="tabpanel">
    <form action="{{ route('admin.update-paypal') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Account Mode') }}</label>
                    <select name="paypal_account_mode" id="paypal_account_mode" class="form-control">
                        <option {{ $basic_payment->paypal_account_mode == 'live' ? 'selected' : '' }} value="live">
                            {{ __('Live') }}</option>
                        <option {{ $basic_payment->paypal_account_mode == 'sandbox' ? 'selected' : '' }}
                            value="sandbox">{{ __('Sandbox') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Gateway charge (%)') }}</label>
                    <input type="text" class="form-control" name="paypal_charge"
                        value="{{ $basic_payment->paypal_charge }}">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="">{{ __('App Id') }}</label>
                        <input type="text" class="form-control" name="paypal_app_id"
                            value="{{ $basic_payment->paypal_app_id }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Client Id') }}</label>
                    @if (env('APP_MODE') == 'DEMO')
                        <input type="text" class="form-control" name="paypal_client_id"
                            value="PAYPAL-TEST-CLIENT98934343-343-ID">
                    @else
                        <input type="text" class="form-control" name="paypal_client_id"
                            value="{{ $basic_payment->paypal_client_id }}">
                    @endif

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Secret Key') }}</label>
                    @if (env('APP_MODE') == 'DEMO')
                        <input type="text" class="form-control" name="paypal_secret_key"
                            value="PAYPAL-TEST-398439483-SECRET-KEY">
                    @else
                        <input type="text" class="form-control" name="paypal_secret_key"
                            value="{{ $basic_payment->paypal_secret_key }}">
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-paypal" class="image-preview">
                <label for="image-upload-paypal"
                    id="image-label-paypal">{{ __('Image') }}</label>
                <input type="file" name="paypal_image" id="image-upload-paypal">
            </div>
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="paypal_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="paypal_status" class="custom-switch-input"
                    {{ $basic_payment?->paypal_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
