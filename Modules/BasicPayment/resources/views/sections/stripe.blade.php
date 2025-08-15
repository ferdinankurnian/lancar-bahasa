<div class="tab-pane fade active show" id="stripe_payment_tab" role="tabpanel">
    <form action="{{ route('admin.update-stripe') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">{{ __('Gateway charge (%)') }}</label>
                    <input type="text" class="form-control" name="stripe_charge"
                        value="{{ $basic_payment->stripe_charge }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="">{{ __('Stripe Key') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="stripe_key" value="DEMO-STRIPE-83493483-TEST-KEY">
            @else
                <input type="text" class="form-control" name="stripe_key" value="{{ $basic_payment->stripe_key }}">
            @endif

        </div>

        <div class="form-group">
            <label for="">{{ __('Stripe Secret') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="stripe_secret" value="STRIPE-TEST98384934-SECRET-KEY">
            @else
                <input type="text" class="form-control" name="stripe_secret"
                    value="{{ $basic_payment->stripe_secret }}">
            @endif
        </div>
        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-stripe" class="image-preview">
                <label for="image-upload-stripe"
                    id="image-label-stripe">{{ __('Image') }}</label>
                <input type="file" name="stripe_image" id="image-upload-stripe">
            </div>

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="stripe_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="stripe_status" class="custom-switch-input"
                    {{ $basic_payment?->stripe_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
