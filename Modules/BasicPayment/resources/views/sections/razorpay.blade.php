<div class="tab-pane fade" id="razorpay_tab" role="tabpanel">
    <form action="{{ route('admin.razorpay-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="form-group col-md-6">
                <label for="">{{ __('Gateway charge (%)') }}</label>
                <input type="text" class="form-control" name="razorpay_charge"
                    value="{{ $payment_setting->razorpay_charge }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Razorpay key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="razorpay_key"
                        value="demo-razorpay-39394343-test-key">
                @else
                    <input type="text" class="form-control" name="razorpay_key"
                        value="{{ $payment_setting->razorpay_key }}">
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Razorpay secret') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="razorpay_secret"
                        value="demo-razorpay-8384934-test-secret">
                @else
                    <input type="text" class="form-control" name="razorpay_secret"
                        value="{{ $payment_setting->razorpay_secret }}">
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Razorpay App Name') }}</label>
                <input type="text" class="form-control" name="razorpay_name"
                    value="{{ $payment_setting->razorpay_name }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Razorpay Description') }}</label>
                <input type="text" class="form-control" name="razorpay_description"
                    value="{{ $payment_setting->razorpay_description }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Theme color') }}</label>
                <input type="color" class="form-control" name="razorpay_theme_color"
                    value="{{ $payment_setting->razorpay_theme_color }}">
            </div>
        </div>

        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-razorpay" class="image-preview">
                <label for="image-upload-razorpay"
                    id="image-label-razorpay">{{ __('Image') }}</label>
                <input type="file" name="razorpay_image" id="image-upload-razorpay">
            </div>

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="razorpay_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="razorpay_status" class="custom-switch-input"
                    {{ $payment_setting?->razorpay_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
