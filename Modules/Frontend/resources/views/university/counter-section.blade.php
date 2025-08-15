@extends('admin.master_layout')
@section('title')
    <title>{{ __('Counter Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Counter Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Counter Section') }}</div>
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
                                                href="{{ route('admin.counter-section.index', ['code' => $language->code]) }}"><i
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
                                <h4>{{ __('Update Counter Section') }}</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.counter-section.update', ['code' => $code]) }}"
                                    method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">{{ __('Title') }}</label>
                                                <input data-translate="true" type="text" id="title" name="title"
                                                    value="{{ $counter->getTranslation($code)?->content?->title }}"
                                                    placeholder="{{ __('Enter Title') }}" class="form-control">
                                                <small>{{ __('wrap your word with [] for highlight and \ for break and {} for bold') }}</small>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">{{ __('Description') }}</label>
                                                <textarea data-translate="true" name="description" id="description" cols="30" rows="10"
                                                    class="form-control text-area-5">{{ $counter->getTranslation($code)?->content?->description }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="total_student">{{ __('Total Students') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_student"
                                                    name="total_student_count"
                                                    value="{{ $counter?->global_content?->total_student_count }}"
                                                    placeholder="{{ __('Total Students') }}" class="form-control">
                                                @error('total_student_count')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="total_instructors">{{ __('Total Instructors') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_instructors"
                                                    name="total_instructor_count"
                                                    value="{{ $counter?->global_content?->total_instructor_count }}"
                                                    placeholder="{{ __('Total Instructors') }}" class="form-control">
                                                @error('total_instructor_count')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="total_courses">{{ __('Total Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_courses"
                                                    name="total_courses_count"
                                                    value="{{ $counter?->global_content?->total_courses_count }}"
                                                    placeholder="{{ __('Total Courses') }}" class="form-control">
                                                @error('total_courses_count')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="button_text">{{ __('Action button text') }}<span
                                                        class="text-danger">
                                                        ({{ __('leave blank for hide') }})</span></label>
                                                <input data-translate="true" type="text" id="button_text"
                                                    name="button_text"
                                                    value="{{ $counter->getTranslation($code)?->content?->button_text }}"
                                                    placeholder="{{ __('Action Button Text') }}" class="form-control">
                                                @error('button_text')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="button_url">{{ __('Action button url') }}</label>
                                                <input data-translate="false" type="text" id="button_url"
                                                    name="button_url"
                                                    value="{{ $counter?->global_content?->button_url }}"
                                                    placeholder="{{ __('Action Button Url') }}" class="form-control">
                                                @error('button_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
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
