@extends('admin.master_layout')
@section('title')
    <title>{{ __('Contact Page Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Contact Page Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Contact Page Section') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Update Contact Section') }}</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.contact-section.update', 1) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">{{ __('Address') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="title" name="address"
                                                    value="{{ $contact?->address }}" placeholder="{{ __('Title') }}"
                                                    class="form-control">
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Phone One') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="title" name="phone_one"
                                                    value="{{ $contact?->phone_one }}" placeholder="{{ __('Phone One') }}"
                                                    class="form-control">
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Phone Two') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="title" name="phone_two"
                                                    value="{{ $contact?->phone_two }}" placeholder="{{ __('Phone Two') }}"
                                                    class="form-control">
                                                @error('two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Email One') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="title" name="email_one"
                                                    value="{{ $contact?->email_one }}" placeholder="{{ __('Email One') }}"
                                                    class="form-control">
                                                @error('email_one')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Email Two') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="title" name="email_two"
                                                    value="{{ $contact?->email_two }}" placeholder="{{ __('Email Two') }}"
                                                    class="form-control">
                                                @error('email_two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Map Link') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="map" name="map"
                                                    value="{{ preg_replace('/^https?:\/\//', '', $contact?->map) }}"
                                                    placeholder="{{ __('Map Link') }}" class="form-control">
                                                @error('map')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
    <script>
        function cleanUrl() {
            let url = $('#map').val();
            if (url.startsWith('https://')) {
                url = url.replace('https://', '');
            } else if (url.startsWith('http://')) {
                url = url.replace('http://', '');
            }
            $('#map').val(url);
        }

        // Handle input event (typing)
        $('#map').on('input', cleanUrl);

        // Handle paste event
        $('#map').on('paste', function() {
            setTimeout(cleanUrl, 0);
        });
    </script>
@endpush
