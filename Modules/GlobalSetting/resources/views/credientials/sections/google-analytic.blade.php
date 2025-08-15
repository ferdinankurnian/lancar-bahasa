<div class="tab-pane fade" id="google_analytic_tab" role="tabpanel">
    <form action="{{ route('admin.update-google-analytic') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">{{ __('Analytic Tracking Id') }}</label>
            @if (env('APP_MODE') == 'DEMO')
                <input type="text" class="form-control" name="google_analytic_id" value="ANA-34343434-TEST-ID">
            @else
                <input type="text" class="form-control" name="google_analytic_id"
                    value="{{ $setting?->google_analytic_id }}">
            @endif
        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="google_analytic_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="google_analytic_status" class="custom-switch-input"
                    {{ $setting?->google_analytic_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>