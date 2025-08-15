<div class="tab-pane fade active show" id="google_recaptcha_tab" role="tabpanel">
    <form action="{{ route('admin.update-google-captcha') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">{{ __('Captcha Site Key') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="recaptcha_site_key" value="ZXN39334XKF-SITE-KEY-TEST">
            @else
                <input type="text" class="form-control" name="recaptcha_site_key"
                    value="{{ $setting->recaptcha_site_key }}">
            @endif
        </div>

        <div class="form-group">
            <label for="">{{ __('Captcha Secret Key') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="recaptcha_secret_key"
                    value="ZXN39334XKF-SECRET-KEY-TEST">
            @else
                <input type="text" class="form-control" name="recaptcha_secret_key"
                    value="{{ $setting->recaptcha_secret_key }}">
            @endif
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="recaptcha_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="recaptcha_status" class="custom-switch-input"
                    {{ $setting?->recaptcha_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>

    </form>
</div>
