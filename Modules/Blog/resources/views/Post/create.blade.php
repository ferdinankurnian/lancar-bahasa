@extends('admin.master_layout')
@section('title')
    <title>{{ __('Create Post') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Create Post') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.blogs.index') }}">{{ __('Blog List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Create Post') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Create Post') }}</h4>
                                <div>
                                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.blogs.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Thumbnail Image') }}<span class="text-danger">*</span></label>
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">{{ __('Image') }}</label>
                                                <input type="file" name="image" id="image-upload">
                                            </div>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="title" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="slug" class="form-control" name="slug"
                                                value="{{ old('slug') }}">
                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Category') }} <span class="text-danger">*</span></label>
                                            <select name="blog_category_id" class="form-control select2" id="category">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach ($categories as $category)
                                                    <option {{ $category->id == old('blog_category_id') ? 'selected' : '' }}
                                                        value="{{ $category->id }}">{{ $category->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                            <textarea name="description" id="" cols="30" rows="10" class="summernote">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>
                                                <input type="hidden" name="show_homepage" class="custom-switch-input"
                                                    value="0">
                                                <input type="checkbox" name="show_homepage" class="custom-switch-input"
                                                    value="1" {{ old('show_homepage') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Show on homepage') }}</span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>
                                                <input type="hidden" value="0" name="is_popular"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="is_popular"
                                                    class="custom-switch-input" {{ old('is_popular') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span
                                                    class="custom-switch-description">{{ __('Mark as a Popular') }}</span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>
                                                <input type="hidden" value="0" name="status"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="status"
                                                    class="custom-switch-input" {{ old('status') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Status') }}</span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Tags') }}</label>
                                            <input type="text" class="form-control tags" name="tags"
                                                value="{{ old('tags') }}">
                                            @error('tags')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('SEO Title') }}</label>
                                            <input type="text" class="form-control" name="seo_title"
                                                value="{{ old('seo_title') }}">
                                            @error('seo_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('SEO Description') }}</label>
                                            <textarea name="seo_description" id="" cols="30" rows="10" class="form-control text-area-5">{{ old('seo_description') }}</textarea>
                                            @error('seo_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-8 offset-md-2">
                                            <x-admin.save-button :text="__('Save')"></x-admin.save-button>
                                        </div>
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
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
    </script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $("#title").on("keyup", function(e) {
                    $("#slug").val(convertToSlug($(this).val()));
                })
            });
        })(jQuery);

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        }
    </script>
@endpush