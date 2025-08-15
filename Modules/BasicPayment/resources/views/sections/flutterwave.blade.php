<div class="tab-pane fade" id="flutterwave_tab" role="tabpanel">
    <form action="{{ route('admin.flutterwave-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="form-group col-md-6">
                <label for="">{{ __('Gateway charge (%)') }}</label>
                <input type="text" class="form-control" name="flutterwave_charge"
                    value="{{ $payment_setting->flutterwave_charge }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Public key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="flutterwave_public_key"
                        value="flutterwave-test-348949439-public-key">
                @else
                    <input type="text" class="form-control" name="flutterwave_public_key"
                        value="{{ $payment_setting->flutterwave_public_key }}">
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Secret key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="flutterwave_secret_key"
                        value="demo-flutterwave-8384934-key-secret">
                @else
                    <input type="text" class="form-control" name="flutterwave_secret_key"
                        value="{{ $payment_setting->flutterwave_secret_key }}">
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Flutterwave App Name') }}</label>
                <input type="text" class="form-control" name="flutterwave_app_name"
                    value="{{ $payment_setting->flutterwave_app_name }}">
            </div>

        </div>

        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-flutterwave" class="image-preview">
                <label for="image-upload-flutterwave"
                    id="image-label-flutterwave">{{ __('Image') }}</label>
                <input type="file" name="flutterwave_image" id="image-upload-flutterwave">
            </div>

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="flutterwave_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="flutterwave_status" class="custom-switch-input"
                    {{ $payment_setting?->flutterwave_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
