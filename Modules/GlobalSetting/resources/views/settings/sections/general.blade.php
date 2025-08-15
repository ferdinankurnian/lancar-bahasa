<div class="tab-pane fade active show" id="general_tab" role="tabpanel">
    <form action="{{ route('admin.update-general-setting') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="">{{ __('App Name') }}</label>
            <input type="text" name="app_name" class="form-control" value="{{ $setting->app_name }}">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Site Address') }}</label>
                    <input type="text" name="site_address" class="form-control" value="{{ $setting?->site_address }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Site Email') }}</label>
                    <input type="text" name="site_email" class="form-control" value="{{ $setting?->site_email }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">{{ __('Timezone') }}</label>
            <select name="timezone" id="" class="form-control select2">
                @foreach ($all_timezones as $timezone)
                    <option value="{{ $timezone->name }}" @selected($setting->timezone == $timezone->name)>
                        {{ $timezone->name }}</option>
                @endforeach
            </select>
        </div>
            <div class="form-group">
                <label for="">{{ __('Mail send time before the live class starts') }} <code>({{ __('in minutes') }})</code></label>
                <input type="number" name="live_mail_send" class="form-control" value="{{ $setting?->live_mail_send }}">
            </div>

        <div class="form-group mb-0">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="header_topbar_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="header_topbar_status"
                    class="custom-switch-input" {{ $setting?->header_topbar_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span
                    class="custom-switch-description">{{ __('Header Topbar') }}</span>
            </label>
        </div>
        <div class="form-group mb-0">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="header_social_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="header_social_status"
                    class="custom-switch-input" {{ $setting?->header_social_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span
                    class="custom-switch-description">{{ __('Topbar Social Icons') }}</span>
            </label>
        </div>
        <div class="form-group mb-0">
            <label class="d-flex align-items-center">
                <input type="hidden" value="0" name="preloader_status" class="custom-switch-input">
                <input type="checkbox" value="1" name="preloader_status"
                    class="custom-switch-input" {{ $setting?->preloader_status == 1 ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span
                    class="custom-switch-description">{{ __('Preloader') }}</span>
            </label>
        </div>
        <div class="form-group mb-0">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="cursor_dot_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="cursor_dot_status"
                    class="custom-switch-input" {{ $setting?->cursor_dot_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span
                    class="custom-switch-description">{{ __('Cursor Style') }}</span>
            </label>
        </div>

        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="is_queable" class="custom-switch-input">
                <input type="checkbox" value="active" name="is_queable"
                    class="custom-switch-input" {{ $setting?->is_queable == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span
                    class="custom-switch-description">{{ __('Send Mails In Queue') }}</span>
            </label>
            @if ($setting->is_queable == 'active')
                <div class="pt-1 text-info"><span class="text-success ">{{ __('Copy and Run This Command') }}:
                    </span>
                    <strong id="copyCronText" onclick="copyText()" title="{{ __('Click to copy') }}"
                        onmouseover="this.style.cursor='pointer'">php artisan schedule:run >>
                        /dev/null
                        2>&1</strong>
                </div>
                <div class="pt-1 text-warning">
                    <b>{{ __('If enabled, you must setup cron job in your server. otherwise it will not work and no mail will
                                        be sent') }}</b>
                </div>
            @endif
        </div>

        <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>

    </form>
</div>
