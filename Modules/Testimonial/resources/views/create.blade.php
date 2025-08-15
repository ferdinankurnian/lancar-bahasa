@extends('admin.master_layout')
@section('title')
    <title>{{ __('Testimonials') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Testimonials') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.testimonial.index') }}">{{ __('Testimonials') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Create Testimonial') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Create Testimonial') }}</h4>
                                <div>
                                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.testimonial.store') }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="{{ __('Enter Name') }}" value="{{ old('name') }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="designation">{{ __('Designation') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="designation"
                                                    id="designation" placeholder="{{ __('Enter designation') }}"
                                                    value="{{ old('designation') }}">
                                                @error('designation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="comment">{{ __('Comment') }} <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control text-area-5"
                                                    placeholder="{{ __('Enter comment') }}">{{ old('comment') }}</textarea>
                                                @error('comment')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="rating">{{ __('Rating') }}</label>
                                                <input type="number" min="0" max="5" step=".1"
                                                    class="form-control" name="rating" id="rating"
                                                    placeholder="{{ __('Enter rating 0-5') }}"
                                                    value="{{ old('rating') }}">
                                                @error('rating')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label>{{ __('Image') }}</label>
                                                <div id="image-preview" class="image-preview">
                                                    <label for="image-upload" id="image-label">{{ __('Image') }}</label>
                                                    <input type="file" name="image" id="image-upload">
                                                </div>
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center offset-md-2 col-md-8">
                                            <x-admin.save-button :text="__('Save')" />
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
        "use strict";
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
@endpush

