<div class="tab-pane fade" id="mollie_tab" role="tabpanel">
    <form action="{{ route('admin.mollie-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="form-group col-md-6">
                <label for="">{{ __('Gateway charge (%)') }}</label>
                <input type="text" class="form-control" name="mollie_charge"
                    value="{{ $payment_setting->mollie_charge }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Mollie key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="mollie_key" value="mollie-test-348949439-key">
                @else
                    <input type="text" class="form-control" name="mollie_key"
                        value="{{ $payment_setting->mollie_key }}">
                @endif
            </div>

        </div>

        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-mollie" class="image-preview">
                <label for="image-upload-mollie"
                    id="image-label-mollie">{{ __('Image') }}</label>
                <input type="file" name="mollie_image" id="image-upload-mollie">
            </div>
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="mollie_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="mollie_status" class="custom-switch-input"
                    {{ $payment_setting?->mollie_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
