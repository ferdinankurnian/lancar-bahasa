@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Post') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Edit Post') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.blogs.index') }}">{{ __('Blog List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Edit Post') }} ({{ request('code') }})</div>
                </div>
            </div>
            <div class="section-body row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="service_card">{{ __('Available Translations') }}</h5>
                            @adminCan('blog.translate')
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
                                    @foreach ($languages = allLanguages() as $language)
                                        <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.blogs.edit', ['blog' => $blog->id, 'code' => $language->code]) }}"><i
                                                    class="fas {{ request('code') == $language->code ? 'fa-eye' : 'fa-edit' }}"></i>
                                                {{ $language->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-2 alert alert-danger" role="alert">
                                @php
                                    $current_language = $languages->where('code', request()->get('code'))->first();
                                @endphp
                                <p>{{ __('Your editing mode') }}:<b> {{ $current_language?->name }}</b></p>
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
                                <h4>{{ __('Edit Post') }}</h4>
                                <div>
                                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.blogs.update', [
                                        'blog' => $blog->id,
                                        'code' => $code,
                                    ]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        @if ($code == $languages->first()->code)
                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>{{ __('Thumbnail Image') }}<span
                                                        class="text-danger">*</span></label>
                                                <div id="image-preview" class="image-preview"
                                                    @if ($blog->image ?? false) style="background-image: url({{ asset($blog->image) }}); background-size: cover; background-position: center center;" @endif>
                                                    <label for="image-upload" id="image-label">{{ __('Image') }}</label>
                                                    <input type="file" name="image" id="image-upload">
                                                </div>
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input data-translate="true" type="text" id="title" class="form-control"
                                                name="title" value="{{ $blog->getTranslation($code)->title }}">
                                        </div>
                                        @if ($code == $languages->first()->code)
                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="slug" class="form-control" name="slug"
                                                    value="{{ $blog->slug }}">
                                            </div>

                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>{{ __('Category') }} <span class="text-danger">*</span></label>
                                                <select name="blog_category_id" class="form-control select2" id="category">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option
                                                        {{ $category->id == old('blog_category_id', $blog->blog_category_id) ? 'selected' : '' }}
                                                            value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                            <textarea name="description" id="" cols="30" rows="10" class="summernote">{!! clean($blog->getTranslation($code)->description) !!}</textarea>
                                        </div>
                                        @if ($code == $languages->first()->code)
                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>
                                                    <input {{ $blog->show_homepage == 1 ? 'checked' : '' }} type="checkbox"
                                                        value="1" name="show_homepage" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span
                                                        class="custom-switch-description">{{ __('Show on homepage') }}</span>
                                                </label>
                                            </div>

                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>
                                                    <input {{ $blog->is_popular == 1 ? 'checked' : '' }} type="checkbox"
                                                        value="1" name="is_popular" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span
                                                        class="custom-switch-description">{{ __('Mark as a Popular') }}</span>
                                                </label>
                                            </div>

                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>
                                                    <input {{ $blog->status == 1 ? 'checked' : '' }} type="checkbox"
                                                        value="1" name="status" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">{{ __('Status') }}</span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-8 offset-md-2">
                                                <label>{{ __('Tags') }}</label>
                                                <input type="text" class="form-control tags" name="tags"
                                                    value="{{ $blog->tags }}">
                                            </div>
                                        @endif

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('SEO Title') }}</label>
                                            <input data-translate="true" type="text" class="form-control"
                                                name="seo_title" value="{{ $blog->getTranslation($code)->seo_title }}">
                                        </div>

                                        <div class="form-group col-md-8 offset-md-2">
                                            <label>{{ __('SEO Description') }}</label>
                                            <textarea data-translate="true" name="seo_description" id="" cols="30" rows="10"
                                                class="form-control text-area-5">{{ $blog->getTranslation($code)->seo_description }}</textarea>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-8 offset-md-2">
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
        </script>
        <script>
            (function($) {
                "use strict";
                $(document).ready(function() {
                    $("#title").on("keyup", function(e) {
                        $("#slug").val(convertToSlug($(this).val()));
                    })
                });
            })(jQuery);

            function convertToSlug(Text) {
                return Text
                    .toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
            }
        </script>
    @else
        <script>
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
                        ["<button><b>{{ __('YES') }}</b></button>", function(instance, toast) {
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
                        ["<button>{{ __('NO') }}</button>", function(instance, toast) {

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
                var btnText = "{{ __('Translate to') }} " + selectedTranslation;
                $('#translate-btn').text(btnText);
            });
        </script>
    @endif
@endpush