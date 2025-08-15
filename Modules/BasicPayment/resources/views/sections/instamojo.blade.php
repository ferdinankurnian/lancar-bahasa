<div class="tab-pane fade" id="instamojo_tab" role="tabpanel">
    <form action="{{ route('admin.instamojo-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="form-group col-md-12">
                <label for="">{{ __('Gateway charge (%)') }}</label>
                <input type="text" class="form-control" name="instamojo_charge"
                    value="{{ $payment_setting->instamojo_charge }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('API key') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="instamojo_api_key"
                        value="instamojo-test-348949439-api-key">
                @else
                    <input type="text" class="form-control" name="instamojo_api_key"
                        value="{{ $payment_setting->instamojo_api_key }}">
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Auth token') }}</label>
                @if (env('APP_MODE') == 'DEMO')
                    <input type="text" class="form-control" name="instamojo_auth_token"
                        value="instamojo-auth-348949439-token">
                @else
                    <input type="text" class="form-control" name="instamojo_auth_token"
                        value="{{ $payment_setting->instamojo_auth_token }}">
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="">{{ __('Account Mode') }}</label>
                <select name="instamojo_account_mode" id="instamojo_account_mode" class="form-control">
                    <option {{ $payment_setting->instamojo_account_mode == 'Sandbox' ? 'selected' : '' }}
                        value="Sandbox">{{ __('Sandbox') }}</option>
                    <option {{ $payment_setting->instamojo_account_mode == 'Live' ? 'selected' : '' }} value="Live">
                        {{ __('Live') }}</option>
                </select>
            </div>

        </div>

        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-instamojo" class="image-preview">
                <label for="image-upload-instamojo"
                    id="image-label-instamojo">{{ __('Image') }}</label>
                <input type="file" name="instamojo_image" id="image-upload-instamojo">
            </div>

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="instamojo_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="instamojo_status" class="custom-switch-input"
                    {{ $payment_setting?->instamojo_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
