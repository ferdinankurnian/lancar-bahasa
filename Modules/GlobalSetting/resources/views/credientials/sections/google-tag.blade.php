<div class="tab-pane fade" id="google_tag_tab" role="tabpanel">
    <form action="{{ route('admin.update-google-tagmaneger') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="text-right">
            <a class="btn btn-danger" data-active-tab="google_data_layer_tab" class="border-bottom search-menu-item" 
            href="{{ route('admin.marketing-setting') }}">{{ __('Google tag data layer manage') }} <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="form-group">
            <label for="">{{ __('Tag manager id') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="google_tagmanager_id" value="ANA-34343434-TEST-ID">
            @else
                <input type="text" class="form-control" name="google_tagmanager_id"
                    value="{{ $setting->google_tagmanager_id }}">
            @endif
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="google_tagmanager_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="google_tagmanager_status" class="custom-switch-input"
                    {{ $setting?->google_tagmanager_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
