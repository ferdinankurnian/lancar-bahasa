<div class="tab-pane fade" id="social_login_tab" role="tabpanel">
    <form action="{{ route('admin.update-social-login') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="">{{ __('Google Client Id') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" value="GMAIL-ID-34343-DEMO-CLIENT" class="form-control" name="gmail_client_id">
            @else
                <input type="text" value="{{ $setting->gmail_client_id }}" class="form-control"
                    name="gmail_client_id">
            @endif

        </div>

        <div class="form-group">
            <label for="">{{ __('Google Secret Id') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" value="GMAIL-ID-343943-TEST-SECRET" class="form-control" name="gmail_secret_id">
            @else
                <input type="text" value="{{ $setting->gmail_secret_id }}" class="form-control"
                    name="gmail_secret_id">
            @endif

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="google_login_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="google_login_status" class="custom-switch-input"
                    {{ $setting?->google_login_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>
        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
    <div class="form-group mt-3">
        <label>{{ __('Callback url ') }} <span data-toggle="tooltip"
            data-placement="top" class="fa fa-info-circle text--primary"
            title="{{__('Copy the Gmail login URL and paste it wherever you need to use it.')}}"></span></label>
        <div class="input-group">
            <input type="text" value="{{url('/auth/google/callback')}}" id="gmail_redirect_url" class="form-control" readonly>
          <div class="input-group-append">
            <div class="input-group-text">
                <span id="copyButton"  data-toggle="tooltip" title="{{__('Copy the Gmail login URL and paste it wherever you need to use it.')}}"><i class="fas fa-copy"></i></span>
            </div>
          </div>
        </div>
      </div>
</div>
