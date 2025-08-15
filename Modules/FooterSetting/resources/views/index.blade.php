@extends('admin.master_layout')
@section('title')
    <title>{{ __('Section Settings') }}</title>
@endsection

@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Footer Settings') }}</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.footersetting.update', 1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Logo') }}<span class="text-danger">*</span></label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">{{ __('Image') }}</label>
                                            <input type="file" name="logo" id="image-upload">
                                        </div>
                                        @error('logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Footer Text') }}</label>
                                        <textarea name="footer_text" class="form-control" cols="30" rows="10">{{ $footerSetting?->footer_text }}</textarea>
                                        @error('footer_text')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Footer Address') }}</label>
                                        <input type="text" class="form-control" name="address" value="{{ $footerSetting?->address }}">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Footer Phone') }}</label>
                                        <input type="text" class="form-control" name="phone" value="{{ $footerSetting?->phone }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Get in touch text') }}</label>
                                        <textarea name="get_in_touch_text" class="form-control" cols="30" rows="10">{{ $footerSetting?->get_in_touch_text }}</textarea>
                                        @error('get_in_touch_text')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Google Play Link') }}</label>
                                        <input type="text" class="form-control" name="google_play_link" value="{{ $footerSetting?->google_play_link }}">
                                        @error('google_play_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Apple Store Link') }}</label>
                                        <input type="text" class="form-control" name="apple_store_link" value="{{ $footerSetting?->apple_store_link }}">
                                        @error('apple_store_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </form>
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
            label_default: "{{ __('Choose Icon') }}",
            label_selected: "{{ __('Change Icon') }}",
            no_label: false,
            success_callback: null
        });
        $('#image-preview').css({
            'background-image': 'url({{ asset($footerSetting?->logo) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });
    </script>
@endpush
