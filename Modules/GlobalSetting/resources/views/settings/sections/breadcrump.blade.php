<div class="tab-pane fade" id="breadcrump_img_tab" role="tabpanel">
    <form action="{{ route('admin.update-breadcrumb') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>{{ __('New Image') }}<span
                    class="text-danger">*</span></label>
            <div id="image-preview-breadcrumb" class="image-preview">
                <label for="image-upload-breadcrumb"
                    id="image-label-breadcrumb">{{ __('Image') }}</label>
                <input type="file" name="breadcrumb_image" id="image-upload-breadcrumb">
            </div>
        </div>


        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
