<div class="tab-pane fade" id="logo_favicon_tab" role="tabpanel">
    <form action="{{ route('admin.update-logo-favicon') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row justify-content-center">

        <div class="form-group col-lg-4">
            <label>{{ __('Logo') }} <code>{{ __('Recommended') }}:(155px x 40px)</code><span class="text-danger"></span></label>
            <div id="image-preview-1" class="image-preview">
                <label for="image-upload-1" id="image-label-1">{{ __('Image') }}</label>
                <input type="file" name="logo" id="image-upload-1">
            </div>
            @error('logo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-lg-4">
            <label>{{ __('Favicon') }}<span class="text-danger"></span></label>
            <div id="image-preview-2" class="image-preview">
                <label for="image-upload-2" id="image-label-2">{{ __('Image') }}</label>
                <input type="file" name="favicon" id="image-upload-2">
            </div>
            @error('favicon')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-lg-4">
            <label>{{ __('Preloader') }}<span class="text-danger"></span></label>
            <div id="image-preview-3" class="image-preview">
                <label for="image-upload-3" id="image-label-3">{{ __('Image') }}</label>
                <input type="file" name="preloader" id="image-upload-3">
            </div>
            @error('preloader')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </div>

       
        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>

@push('js')
<script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        "use strict";
        $.uploadPreview({
            input_field: "#image-upload-1",
            preview_box: "#image-preview-1",
            label_field: "#image-label-1",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        $('#image-preview-1').css({
            'background-image': 'url({{ !empty($setting->logo) ? asset($setting->logo) : '' }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });

        $.uploadPreview({
            input_field: "#image-upload-2",
            preview_box: "#image-preview-2",
            label_field: "#image-label-2",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        $('#image-preview-2').css({
            'background-image': 'url({{ asset(@$setting->favicon) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });

        $.uploadPreview({
            input_field: "#image-upload-3",
            preview_box: "#image-preview-3",
            label_field: "#image-label-3",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        $('#image-preview-3').css({
            'background-image': 'url({{ asset(@$setting->preloader) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });
    </script>
@endpush
