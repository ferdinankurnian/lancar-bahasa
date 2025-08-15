<div class="tab-pane fade" id="paystack_tab" role="tabpanel">
    <form action="{{ route('admin.paystack-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="form-group col-md-6">
                <label for="">{{ __('Gateway charge (%)') }}</label>
                <input type="text" class="form-control" name="paystack_charge"
                    value="{{ $payment_setting->paystack_charge }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Public key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="paystack_public_key"
                        value="paystack-test-348949439-public-key">
                @else
                    <input type="text" class="form-control" name="paystack_public_key"
                        value="{{ $payment_setting->paystack_public_key }}">
                @endif
            </div>

            <div class="form-group col-md-12">
                <label for="">{{ __('Secret key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="paystack_secret_key"
                        value="demo-paystack-8384934-key-secret">
                @else
                    <input type="text" class="form-control" name="paystack_secret_key"
                        value="{{ $payment_setting->paystack_secret_key }}">
                @endif
            </div>

        </div>

        
        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-paystack" class="image-preview">
                <label for="image-upload-paystack"
                    id="image-label-paystack">{{ __('Image') }}</label>
                <input type="file" name="paystack_image" id="image-upload-paystack">
            </div>
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="paystack_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="paystack_status" class="custom-switch-input"
                    {{ $payment_setting?->paystack_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
