<div class="tab-pane fade" id="tawk_chat_tab" role="tabpanel">
    <form action="{{ route('admin.update-tawk-chat') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="">{{ __('Tawk Chat Link') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="tawk_chat_link"
                    value="https://www.tawk.to/demo-link/34893439">
            @else
                <input type="text" class="form-control" name="tawk_chat_link" value="{{ $setting->tawk_chat_link }}">
            @endif

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="tawk_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="tawk_status" class="custom-switch-input"
                    {{ $setting?->tawk_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
