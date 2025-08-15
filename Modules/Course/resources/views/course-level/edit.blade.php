@extends('admin.master_layout')
@section('title')
    <title>{{ __('Course Level List') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Level') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.course-level.index') }}">{{ __('Course Level List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Edit Level') }}</div>
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
                                                href="{{ route('admin.course-level.edit', ['course_level' => $courseLevel->id, 'code' => $language->code]) }}"><i
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
                                <h4>{{ __('Edit Level') }}</h4>
                                <div>
                                    <a href="{{ route('admin.course-level.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.course-level.update', ['course_level' => $courseLevel->id, 'code' => $code]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }}<span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" id="name" name="name"
                                                    value="{{ old('name', $courseLevel->getTranslation($code)->name) }}"
                                                    placeholder="{{ __('Enter name') }}" class="form-control">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div
                                            class="col-md-8 offset-md-2 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="status">{{ __('Status') }}<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="status">
                                                    <option @selected($courseLevel->status == 1) value="1">{{ __('Active') }}
                                                    </option>
                                                    <option @selected($courseLevel->status == 0) value="0">
                                                        {{ __('Inactive') }}</option>
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
    <script>
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

            $('#translate-btn').on('click', function() {
                translateAllTo("{{ $code }}");
            })
        });
    </script>
@endpush
