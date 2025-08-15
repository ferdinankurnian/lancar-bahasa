<div class="tab-pane fade" id="direct_bank_tab" role="tabpanel">
    <form action="{{ route('admin.update-bank-payment') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="">{{ __('Account Information') }}</label>
            <textarea name="bank_information" id="" cols="30" rows="10" class="text-area-5 form-control">{{ $basic_payment->bank_information }}</textarea>
        </div>

        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-bank" class="image-preview">
                <label for="image-upload-bank"
                    id="image-label-bank">{{ __('Image') }}</label>
                <input type="file" name="bank_image" id="image-upload-bank">
            </div>

        </div>
        <div class="form-group">
            <label class="d-flex align-items-center">
                <input type="hidden" value="inactive" name="bank_status" class="custom-switch-input">
                <input type="checkbox" value="active" name="bank_status" class="custom-switch-input"
                    {{ $basic_payment?->bank_status == 'active' ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ __('Status') }}</span>
            </label>
        </div>

        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
