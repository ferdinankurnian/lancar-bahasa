@extends('admin.master_layout')
@section('title')
    <title>{{ __('Hero Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Hero Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Dashboard') }}</div>
                </div>
            </div>
            <div class="section-body row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="service_card">{{ __('Available Translations') }}</h5>

                            <hr>
                            @if ($code !== $languages->first()->code)
                                <button onclick="translateAll()" class="btn btn-primary"
                                    id="translate-btn">{{ __('Translate') }}</button>
                            @endif

                        </div>
                        <div class="card-body">
                            <div class="lang_list_top">
                                <ul class="lang_list">
                                    @foreach ($languages as $language)
                                        <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.hero-section.index', ['code' => $language->code]) }}"><i
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
                                <h4>{{ __('Update Hero Section') }}</h4>
                                <div>
                                    <a href="{{ route('admin.blog-category.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.hero-section.update', ['code' => $code]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">{{ __('Title') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="title" name="title"
                                                    value="{{ $heroSection->getTranslation($code)?->content?->title }}"
                                                    placeholder="{{ __('Enter Title') }}" class="form-control">
                                                <small>{{ __('wrap your word with [] for highlight and \ for break and {} for bold') }}</small>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="sub_title">{{ __('Sub Title') }}<span class="text-danger">
                                                        ({{ __('leave blank for hide') }})</span></label>
                                                <input data-translate="true" type="text" id="sub_title" name="sub_title"
                                                    value="{{ $heroSection->getTranslation($code)?->content?->sub_title }}"
                                                    placeholder="{{ __('Enter Subtitle') }}" class="form-control">
                                                <small>{{ __('use \ for break') }}</small>
                                                @error('sub_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_students">{{ __('Total Students') }} <span
                                                        class="text-danger">
                                                        ({{ __('leave blank for hide') }})</span></label>
                                                <input data-translate="true" type="text" id="total_students"
                                                    name="total_student"
                                                    value="{{ $heroSection->getTranslation($code)?->content?->total_student }}"
                                                    placeholder="{{ __('10k') }}" class="form-control">
                                                @error('total_student')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_courses">{{ __('Total Recipes') }} <span
                                                        class="text-danger">
                                                        ({{ __('leave blank for hide') }})</span></label>
                                                <input data-translate="true" type="text" id="total_courses"
                                                    name="total_courses"
                                                    value="{{ $heroSection->getTranslation($code)?->content?->total_courses }}"
                                                    placeholder="{{ __('10k') }}" class="form-control">
                                                @error('total_courses')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if ($code == $languages->first()->code)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('Banner Image') }}<span
                                                            class="text-danger">*</span></label>
                                                    <div id="image-preview" class="image-preview">
                                                        <label for="image-upload"
                                                            id="image-label">{{ __('Image') }}</label>
                                                        <input data-translate="false" type="file" name="banner_image"
                                                            id="image-upload">
                                                    </div>
                                                    @error('banner_image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('Banner Background') }}<span
                                                            class="text-danger">*</span></label>
                                                    <div id="image-preview-2" class="image-preview">
                                                        <label for="image-upload-2"
                                                            id="image-label-2">{{ __('Image') }}</label>
                                                        <input data-translate="false" type="file"
                                                            name="banner_background" id="image-upload-2">
                                                    </div>
                                                    @error('banner_background')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('Banner Background Two') }}<span
                                                            class="text-danger">*</span></label>
                                                    <div id="image-preview-3" class="image-preview">
                                                        <label for="image-upload-3"
                                                            id="image-label-3">{{ __('Image') }}</label>
                                                        <input data-translate="false" type="file"
                                                            name="banner_background_two" id="image-upload-3">
                                                    </div>
                                                    @error('banner_background_two')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('Hero Background') }}<span
                                                            class="text-danger">*</span></label>
                                                    <div id="image-preview-4" class="image-preview">
                                                        <label for="image-upload-4"
                                                            id="image-label-4">{{ __('Image') }}</label>
                                                        <input data-translate="false" type="file"
                                                            name="hero_background" id="image-upload-4">
                                                    </div>
                                                    @error('hero_background')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('Enrolled students image') }}<span
                                                            class="text-danger">*</span></label>
                                                    <div id="image-preview-5" class="image-preview">
                                                        <label for="image-upload-5"
                                                            id="image-label-5">{{ __('Image') }}</label>
                                                        <input data-translate="false" type="file"
                                                            name="enroll_students_image" id="image-upload-5">
                                                    </div>
                                                    @error('enroll_students_image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif


                                        <div class="text-center col-12">
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
    @if ($code == $languages->first()->code)
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
            $.uploadPreview({
                input_field: "#image-upload-2",
                preview_box: "#image-preview-2",
                label_field: "#image-label-2",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
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

            $.uploadPreview({
                input_field: "#image-upload-4",
                preview_box: "#image-preview-4",
                label_field: "#image-label-4",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });
            $.uploadPreview({
                input_field: "#image-upload-5",
                preview_box: "#image-preview-5",
                label_field: "#image-label-5",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview').css({
                'background-image': "url('{{ asset($heroSection?->global_content?->banner_image) }}')",
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
            $('#image-preview-2').css({
                'background-image': "url('{{ asset($heroSection?->global_content?->banner_background) }}')",
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
            $('#image-preview-3').css({
                'background-image': "url('{{ asset($heroSection?->global_content?->banner_background_two) }}')",
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $('#image-preview-4').css({
                'background-image': "url('{{ asset($heroSection?->global_content?->hero_background) }}')",
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $('#image-preview-5').css({
                'background-image': 'url({{ asset($heroSection?->global_content?->enroll_students_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        </script>
    @endif
    <script>
        $('#translate-btn').on('click', function() {
            translateAllTo("{{ $code }}");
        })
    </script>
@endpush
