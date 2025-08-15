<div class="tab-pane fade" id="facebook_pixel_tab" role="tabpanel">
    <form action="{{ route('admin.update-facebook-pixel') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">{{ __('Facebook App Id') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" value="PIXEL-APP-434334-DEMO-ID" class="form-control" name="pixel_app_id">
            @else
                <input type="text" value="{{ $setting->pixel_app_id }}" class="form-control" name="pixel_app_id">
            @endif
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="pixel_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="pixel_status" class="custom-switch-input"
                    {{ $setting?->pixel_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>
        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
