<div class="tab-pane fade active show" id="midtrans_tab" role="tabpanel" aria-labelledby="midtrans-tab">
    <div class="card-body">
        <form action="{{ route('admin.update-midtrans') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="server_key">{{ __('Midtrans Server Key') }}</label>
                <input type="text" name="server_key" class="form-control" value="{{ $midtrans_payment->server_key ?? '' }}">
            </div>

            <div class="form-group">
                <label for="client_key">{{ __('Midtrans Client Key') }}</label>
                <input type="text" name="client_key" class="form-control" value="{{ $midtrans_payment->client_key ?? '' }}">
            </div>

            <div class="form-group">
                <label for="is_production">{{ __('Environment') }}</label>
                <select name="is_production" class="form-control">
                    <option value="false" {{ (isset($midtrans_payment->is_production) && $midtrans_payment->is_production == 'false') ? 'selected' : '' }}>{{ __('Sandbox') }}</option>
                    <option value="true" {{ (isset($midtrans_payment->is_production) && $midtrans_payment->is_production == 'true') ? 'selected' : '' }}>{{ __('Production') }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">{{ __('Status') }}</label>
                <select name="status" class="form-control">
                    <option value="1" {{ (isset($midtrans_payment->status) && $midtrans_payment->status == 1) ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ (isset($midtrans_payment->status) && $midtrans_payment->status == 0) ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">{{ __('Image') }}</label>
                <input type="file" name="image" class="form-control" id="image-upload-midtrans">
            </div>

            <div class="form-group">
                <div id="image-preview-midtrans" class="image-preview"></div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        </form>
    </div>
</div>