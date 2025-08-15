@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Testimonial') }}</title>
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
                    <div class="breadcrumb-item">{{ __('Edit Testimonial') }}</div>
                </div>
            </div>
            <div class="section-body row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="service_card">{{ __('Available Translations') }}</h5>
                            @adminCan('testimonial.translate')
                                <hr>
                                @if ($code !== $languages->first()->code)
                                    <button onclick="translateAll()" class="btn btn-primary"
                                        id="translate-btn">{{ __('Translate') }}</button>
                                @endif
                            @endadminCan
                        </div>
                        <div class="card-body">
                            <div class="lang_list_top">
                                <ul class="lang_list">
                                    @foreach (allLanguages() as $language)
                                        <li>
                                            <a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.testimonial.edit', ['testimonial' => $testimonial->id, 'code' => $language->code]) }}">
                                                <i
                                                    class="fas {{ request('code') == $language->code ? 'fa-eye' : 'fa-edit' }}"></i>
                                                {{ $language->name }}
                                            </a>
                                        </li>
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
                                <h4>{{ __('Edit Testimonial') }}</h4>
                                <div>
                                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.testimonial.update', [
                                        'testimonial' => $testimonial->id,
                                        'code' => $code,
                                    ]) }}"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" class="form-control"
                                                    name="name" id="name" placeholder="{{ __('Enter Name') }}"
                                                    value="{{ old('name', $testimonial->getTranslation($code)->name) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="designation">{{ __('Designation') }} <span
                                                        class="text-danger">*</span></label>
                                                <input data-translate="true" type="text" class="form-control"
                                                    name="designation" id="designation"
                                                    placeholder="{{ __('Enter designation') }}"
                                                    value="{{ old('designation', $testimonial->getTranslation($code)->designation) }}">
                                                @error('designation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-2 col-md-8">
                                            <div class="form-group">
                                                <label for="comment">{{ __('Comment') }} <span
                                                        class="text-danger">*</span></label>
                                                <textarea data-translate="true" name="comment" id="comment" cols="30" rows="10"
                                                    class="form-control text-area-5" placeholder="{{ __('Enter comment') }}">{{ old('comment', $testimonial->getTranslation($code)->comment) }}</textarea>
                                                @error('comment')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($code == $languages->first()->code)
                                            <div class="offset-md-2 col-md-8">
                                                <div class="form-group">
                                                    <label for="rating">{{ __('Rating') }}</label>
                                                    <input type="number" min="0" max="5" step=".1"
                                                        class="form-control" name="rating" id="rating"
                                                        placeholder="{{ __('Enter rating 0-5') }}"
                                                        value="{{ old('rating', $testimonial->rating) }}">
                                                    @error('rating')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="offset-md-2 col-md-8">
                                                <div class="form-group">
                                                    <label>{{ __('Image') }}</label>
                                                    <div id="image-preview" class="image-preview"
                                                        @if ($testimonial->image) style="background-image: url({{ asset($testimonial->image) }}); background-size: cover; background-position: center center;" @endif>
                                                        <label for="image-upload"
                                                            id="image-label">{{ __('Image') }}</label>
                                                        <input type="file" name="image" id="image-upload">
                                                    </div>
                                                    @error('image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-center offset-md-2 col-md-8">
                                            <x-admin.update-button :text="__('Update')"></x-admin.update-button>
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
    <script>
        "use strict";
        var isTranslatingInputs = true;

        function translateOneByOne(inputs, index = 0) {
            if (index >= inputs.length) {
                if (isTranslatingInputs) {
                    isTranslatingInputs = false;
                    translateAllTextarea();
                }
                $('#translate-btn').prop('disabled', false);
                $('#update-btn').prop('disabled', false);
                return;
            }

            var $input = $(inputs[index]);
            var inputValue = $input.val();

            if (inputValue) {
                $.ajax({
                    url: "{{ route('admin.languages.update.single') }}",
                    type: "POST",
                    data: {
                        lang: '{{ $code }}',
                        text: inputValue,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $input.prop('disabled', true);
                        iziToast.show({
                            timeout: false,
                            close: true,
                            theme: 'dark',
                            icon: 'loader',
                            iconUrl: 'https://hub.izmirnic.com/Files/Images/loading.gif',
                            title: "{{ __('Translation Processing, please wait...') }}",
                            position: 'center',
                        });
                    },
                    success: function(response) {
                        $input.val(response);
                        $input.prop('disabled', false);
                        iziToast.destroy();
                        toastr.success("{{ __('Translated Successfully!') }}");
                        translateOneByOne(inputs, index + 1);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                        iziToast.destroy();
                        toastr.error('Error', 'Error');
                    }
                });
            } else {
                translateOneByOne(inputs, index + 1);
            }
        }

        function translateAll() {
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: "{{ __('This will take a while!') }}",
                message: "{{ __('Are you sure?') }}",
                position: 'center',
                buttons: [
                    ["<button><b>{{ __('Yes') }}</b></button>", function(instance, toast) {
                        var isDemo = "{{ env('PROJECT_MODE') ?? 1 }}";

                        if (isDemo == 0) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            toastr.error("{{ __('This Is Demo Version. You Can Not Change Anything') }}");
                            return;
                        }

                        $('#translate-btn').prop('disabled', true);
                        $('#update-btn').prop('disabled', true);

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');

                        var inputs = $('input[data-translate="true"]').toArray();
                        translateOneByOne(inputs);

                    }, true],
                    ["<button>{{ __('No') }}</button>", function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');

                    }],
                ],
                onClosing: function(instance, toast, closedBy) {},
                onClosed: function(instance, toast, closedBy) {}
            });
        };

        function translateAllTextarea() {
            var inputs = $('textarea[data-translate="true"]').toArray();
            if (inputs.length === 0) {
                return;
            }
            translateOneByOne(inputs);
        }

        $(document).ready(function() {
            var selectedTranslation = $('#selected-language').text();
            var btnText = "{{ __('Translate to') }}" + selectedTranslation;
            $('#translate-btn').text(btnText);
        });
    </script>
@endpush

