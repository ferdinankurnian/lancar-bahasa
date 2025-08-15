<div class="tab-pane fade" id="wasabi_tab" role="tabpanel">
    <form action="{{ route('admin.update-wasabi-cloud') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="">{{ __('Access ID') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="wasabi_access_id" value="access_key_id">
            @else
                <input type="text" class="form-control" name="wasabi_access_id"
                    value="{{ $setting->wasabi_access_id }}">
            @endif
        </div>
        <div class="form-group">
            <label for="">{{ __('Secret key') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="wasabi_secret_key" value="secret_key">
            @else
                <input type="text" class="form-control" name="wasabi_secret_key"
                    value="{{ $setting->wasabi_secret_key }}">
            @endif
        </div>
        <div class="form-group">
            <label for="">{{ __('Bucket Name') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="wasabi_bucket" value="bucket_name">
            @else
                <input type="text" class="form-control" name="wasabi_bucket"
                    value="{{ $setting->wasabi_bucket }}">
            @endif
        </div>
        <div class="form-group">
            <label for="">{{ __('Region') }}</label>
            <select name="wasabi_region"  class="form-control">
                @foreach(config('cloud-storage-region.region') as $key => $value)
                    <option {{ $setting?->wasabi_region == $key ? 'selected' : '' }} value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="wasabi_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="wasabi_status" class="custom-switch-input"
                    {{ $setting?->wasabi_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
