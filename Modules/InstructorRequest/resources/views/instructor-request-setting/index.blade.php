@extends('admin.master_layout')
@section('title')
    <title>{{ __('Instructor Request Settings') }}</title>
@endsection

@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Instructor Request Settings') }}</h1>
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
                                                href="{{ route('admin.instructor-request-setting.index', ['code' => $language->code]) }}"><i
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
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.instructor-request-setting.update', ['instructor_request_setting' => 1, 'code' => $code]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>{{ __('Do Instructor need to submit document / certificate?') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="need_certificate" class="form-control">
                                                <option @selected($instructorRequestSetting?->need_certificate == 1) value="1">{{ __('Yes') }}</option>
                                                <option @selected($instructorRequestSetting?->need_certificate == 0) value="0">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>{{ __('Do Instructor need to submit Identity Scan?') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="need_identity_scan" class="form-control">
                                                <option @selected($instructorRequestSetting?->need_identity_scan == 1) value="1">{{ __('Yes') }}</option>
                                                <option @selected($instructorRequestSetting?->need_identity_scan == 0) value="0">{{ __('No') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                          <label>{{ __('Instructions for Instructor') }} <span
                                                  class="text-danger">*</span></label>
                                          <textarea name="instructions" class="form-control summernote">{{ $instructorRequestSetting?->getTranslation($code)?->instructions }}</textarea>
                                          <small>{{ __('this will be displayed on the top of the become instructor page') }}</small>
                                      </div>
                                  
                                    </div>
                                    <br>
                                    <br>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary">{{ __('Save changes') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
