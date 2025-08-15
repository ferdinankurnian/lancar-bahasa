@extends('admin.master_layout')
@section('title')
    <title>{{ __('Banner Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Banner Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Update Banner Section') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Update Banner Section') }}</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.banner-section.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="video_url">{{ __('Video url') }}</label>
                                                <input type="text" id="video_url" name="video_url"
                                                    value="{{ $bannerSection?->global_content?->video_url }}"
                                                    placeholder="{{ __('Video url') }}" class="form-control">
                                                @error('video_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ __('Image') }}</label>
                                                <div id="image-preview-3" class="image-preview">
                                                    <label for="image-upload-3" id="image-label-3">{{ __('Image') }}</label>
                                                    <input data-translate="false" type="file" name="bg_image"
                                                        id="image-upload-3">
                                                </div>
                                                @error('bg_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ __('Image') }}<span class="text-danger">*</span></label>
                                                <div id="image-preview" class="image-preview">
                                                    <label for="image-upload"
                                                        id="image-label">{{ __('Image') }}</label>
                                                    <input data-translate="false" type="file" name="student_image"
                                                        id="image-upload">
                                                </div>
                                                @error('student_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-center col">
                                        <x-admin.save-button :text="__('Save')">
                                        </x-admin.save-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
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
            'background-image': 'url({{ asset($bannerSection?->global_content?->bg_image) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        $('#image-preview').css({
            'background-image': 'url({{ asset($bannerSection?->global_content?->student_image) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });
    </script>
@endpush
