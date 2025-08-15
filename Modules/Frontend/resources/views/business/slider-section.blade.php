@extends('admin.master_layout')
@section('title')
    <title>{{ __('Slider Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Slider Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Slider Section') }}</div>
                </div>
            </div>
            <div class="section-body row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="service_card">{{ __('Available Translations') }}</h5>

                            <hr>
                            @if ($code !== $languages->first()->code)
                                <button class="btn btn-primary" id="translate-btn">{{ __('Translate') }}</button>
                            @endif

                        </div>
                        <div class="card-body">
                            <div class="lang_list_top">
                                <ul class="lang_list">
                                    @foreach ($languages as $language)
                                        <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.slider-section.index', ['code' => $language->code]) }}"><i
                                                    class="fas {{ request('code') == $language->code ? 'fa-eye' : 'fa-edit' }}"></i>
                                                {{ $language->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-2 alert alert-danger" role="alert">
                                @php
                                    $current_language = $languages->where('code', request()->get('code'))->first();
                                @endphp
                                <p>{{ __('Your editing mode') }} :
                                    <b>{{ $current_language?->name }}</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Slider Section') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.slider-section.update', ['code' => $code]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-2 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label>{{ __('Image One') }}<span class="text-danger">*</span></label>
                                                <div id="image-preview-one" class="image-preview">
                                                    <label for="image-upload"
                                                        id="image-label-one">{{ __('Image') }}</label>
                                                    <input type="file" name="image_one" id="image-upload-one">
                                                </div>
                                                @error('image_one')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="short_title_one">{{ __('Short Title') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="short_title_one"
                                                    name="short_title_one"
                                                    value="{{ $sliderSection->getTranslation($code)?->content?->short_title_one }}"
                                                    placeholder="{{ __('Enter Subtitle') }}" class="form-control">
                                                @error('short_title_one')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Title One') }}<span class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="title" name="title_one"
                                                    value="{{ $sliderSection?->getTranslation($code)?->content?->title_one }}"
                                                    placeholder="{{ __('Enter Title') }}" class="form-control">
                                                @error('title_one')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Sub Title One') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="sub_title"
                                                    name="sub_title_one"
                                                    value="{{ $sliderSection?->getTranslation($code)?->content?->sub_title_one }}"
                                                    placeholder="{{ __('Enter Sub Title') }}" class="form-control">
                                                @error('sub_title_one')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label>{{ __('Image Two') }}<span class="text-danger">*</span></label>
                                                <div id="image-preview-two" class="image-preview">
                                                    <label for="image-upload"
                                                        id="image-label-two">{{ __('Image') }}</label>
                                                    <input type="file" name="image_two" id="image-upload-two">
                                                </div>
                                                @error('image_two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="short_title_two">{{ __('Short Title') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="short_title_two"
                                                    name="short_title_two"
                                                    value="{{ $sliderSection->getTranslation($code)?->content?->short_title_two }}"
                                                    placeholder="{{ __('Enter Subtitle') }}" class="form-control">
                                                @error('short_title_two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Title Two') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="title" name="title_two"
                                                    value="{{ $sliderSection?->getTranslation($code)?->content?->title_two }}"
                                                    placeholder="{{ __('Enter Title') }}" class="form-control">
                                                @error('title_two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Sub Title Two') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="sub_title_two"
                                                    name="sub_title_two"
                                                    value="{{ $sliderSection?->getTranslation($code)?->content?->sub_title_two }}"
                                                    placeholder="{{ __('Enter Sub Title') }}" class="form-control">
                                                @error('sub_title_two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label>{{ __('Image Three') }}<span class="text-danger">*</span></label>
                                                <div id="image-preview-three" class="image-preview">
                                                    <label for="image-upload"
                                                        id="image-label-three">{{ __('Image') }}</label>
                                                    <input type="file" name="image_three" id="image-upload-three">
                                                </div>
                                                @error('image_three')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="short_title_three">{{ __('Short Title') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="short_title_three"
                                                    name="short_title_three"
                                                    value="{{ $sliderSection->getTranslation($code)?->content?->short_title_three }}"
                                                    placeholder="{{ __('Enter Subtitle') }}" class="form-control">
                                                @error('short_title_three')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Title Three') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="title"
                                                    name="title_three"
                                                    value="{{ $sliderSection?->getTranslation($code)?->content?->title_three }}"
                                                    placeholder="{{ __('Enter Title Three') }}" class="form-control">
                                                @error('title_three')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Sub Title Three') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="sub_title_three"
                                                    name="sub_title_three"
                                                    value="{{ $sliderSection?->getTranslation($code)?->content?->sub_title_three }}"
                                                    placeholder="{{ __('Enter Sub Title') }}" class="form-control">
                                                @error('sub_title_three')
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
    @if ($code == $languages->first()->code)
        <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $.uploadPreview({
                    input_field: "#image-upload-one",
                    preview_box: "#image-preview-one",
                    label_field: "#image-label-one",
                    label_default: "{{ __('Choose Icon') }}",
                    label_selected: "{{ __('Change Icon') }}",
                    no_label: false,
                    success_callback: null
                });

                $('#image-preview-one').css({
                    'background-image': 'url({{ asset($sliderSection?->global_content?->image_one) }})',
                    'background-size': 'contain',
                    'background-position': 'center',
                    'background-repeat': 'no-repeat'
                });

                $.uploadPreview({
                    input_field: "#image-upload-two",
                    preview_box: "#image-preview-two",
                    label_field: "#image-label-two",
                    label_default: "{{ __('Choose Icon') }}",
                    label_selected: "{{ __('Change Icon') }}",
                    no_label: false,
                    success_callback: null
                });

                $('#image-preview-two').css({
                    'background-image': 'url({{ asset($sliderSection?->global_content?->image_two) }})',
                    'background-size': 'contain',
                    'background-position': 'center',
                    'background-repeat': 'no-repeat'
                });

                $.uploadPreview({
                    input_field: "#image-upload-three",
                    preview_box: "#image-preview-three",
                    label_field: "#image-label-three",
                    label_default: "{{ __('Choose Icon') }}",
                    label_selected: "{{ __('Change Icon') }}",
                    no_label: false,
                    success_callback: null
                });

                $('#image-preview-three').css({
                    'background-image': 'url({{ asset($sliderSection?->global_content?->image_three) }})',
                    'background-size': 'contain',
                    'background-position': 'center',
                    'background-repeat': 'no-repeat'
                });
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#translate-btn').on('click', function() {
                translateAllTo("{{ $code }}");
            })
        });
    </script>
@endpush
