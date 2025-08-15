@extends('admin.master_layout')
@section('title')
    <title>{{ __('Course Category') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Category') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.course-category.index') }}">{{ __('Course Category List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Add Category') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Add Category') }}</h4>
                                <div>
                                    <a href="{{ route('admin.course-category.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.course-category.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="name" name="name"
                                                    value="{{ old('name') }}" placeholder="{{ __('Enter name') }}"
                                                    class="form-control">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="slug">{{ __('Slug') }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="slug" name="slug"
                                                    value="{{ old('slug') }}" placeholder="{{ __('Enter Slug') }}"
                                                    class="form-control">
                                                @error('slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label>{{ __('Icon') }}<span class="text-danger">*</span></label>
                                                <div id="image-preview" class="image-preview">
                                                    <label for="image-upload" id="image-label">{{ __('Icon') }}</label>
                                                    <input type="file" name="icon" id="image-upload">
                                                </div>
                                                @error('icon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="status">{{ __('Show at trading') }}<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="show_at_trending">
                                                    <option value="1">{{ __('Yes') }}</option>
                                                    <option value="0">{{ __('No') }}</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="status">{{ __('Status') }}<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="status">
                                                    <option value="1">{{ __('Active') }}</option>
                                                    <option value="0">{{ __('Inactive') }}</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center offset-md-2 col-md-8">
                                            <x-admin.save-button :text="__('Save')">
                                            </x-admin.save-button>
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
        'use strict';
        $(function() {
            const $name = $("#name"),
                $slug = $("#slug");

            $name.on("keyup", function(e) {
                $slug.val(convertToSlug($name.val()));
            });

            function convertToSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[^a-z\s-]/g, "") // Remove all non-word characters (except -)
                    .replace(/\s+/g, "-") // Replace spaces with -
                    .replace(/-+/g, "-"); // Replace multiple - with single -
            }

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
                label_default: "{{ __('Choose Icon') }}",
                label_selected: "{{ __('Change Icon') }}",
                no_label: false,
                success_callback: null
            });
        });
    </script>
@endpush
