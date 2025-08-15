<div class="tab-pane fade" id="aws_tab" role="tabpanel">
    <form action="{{ route('admin.update-aws-cloud') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">{{ __('Access ID') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="aws_access_id" value="access_key_id">
            @else
                <input type="text" class="form-control" name="aws_access_id"
                    value="{{ $setting->aws_access_id }}">
            @endif
        </div>
        <div class="form-group">
            <label for="">{{ __('Secret key') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="aws_secret_key" value="secret_key">
            @else
                <input type="text" class="form-control" name="aws_secret_key"
                    value="{{ $setting->aws_secret_key }}">
            @endif
        </div>
        <div class="form-group">
            <label for="">{{ __('Bucket Name') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="aws_bucket" value="bucket_name">
            @else
                <input type="text" class="form-control" name="aws_bucket"
                    value="{{ $setting->aws_bucket }}">
            @endif
        </div>
        <div class="form-group">
            <label for="">{{ __('Region') }}</label>
            <input type="text" class="form-control" name="aws_region" value="{{ $setting->aws_region }}">
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="aws_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="aws_status" class="custom-switch-input"
                    {{ $setting?->aws_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
