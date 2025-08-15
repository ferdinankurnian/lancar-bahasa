@extends('admin.master_layout')
@section('title')
    <title>{{ __('Featured Instructors') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Featured Instructors') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Featured Instructors') }}</div>
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
                                                href="{{ route('admin.featured-instructor-section.edit', ['featured_instructor_section' => 1, 'code' => $language->code]) }}"><i
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
                                <h4>{{ __('Featured Instructors Section') }}</h4>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.featured-instructor-section.update', ['featured_instructor_section' => $featured->id ?? 1, 'code' => $code]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Title') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="button_text" name="title"
                                                    value="{{ $featured->getTranslation($code)?->title }}"
                                                    placeholder="{{ __('Title') }}" class="form-control">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Sub Title') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="button_text"
                                                    name="sub_title"
                                                    value="{{ $featured->getTranslation($code)?->sub_title }}"
                                                    placeholder="{{ __('Sub Title') }}" class="form-control">
                                                @error('sub_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="button_text">{{ __('button text') }}<span class="text-danger">
                                                        ({{ __('leave blank for hide') }})</span></label>
                                                <input data-translate="true" type="text" id="button_text"
                                                    name="button_text"
                                                    value="{{ $featured->getTranslation($code)?->button_text }}"
                                                    placeholder="{{ __('Button Text') }}" class="form-control">
                                                @error('button_text')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="button_url">{{ __('Button url') }}</label>
                                                <input type="text" id="button_url" name="button_url"
                                                    value="{{ $featured->button_url }}"
                                                    placeholder="{{ __('Button Url') }}" class="form-control">
                                                @error('button_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="">{{ __('Featured Instructors') }}</label>
                                                <select name="instructor_ids[]" class="select2" id=""
                                                    multiple>
                                                    @foreach ($instructors as $instructor)
                                                        <option @selected(in_array($instructor->id, json_decode($featured->instructor_ids??'[]'))) value="{{ $instructor->id }}">{{ $instructor->name }}
                                                            ({{ $instructor->email }})</option>
                                                    @endforeach
                                                </select>
                                                @error('instructor_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


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
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#translate-btn').on('click', function() {
                translateAllTo("{{ $code }}");
            })
        });
    </script>
@endpush
