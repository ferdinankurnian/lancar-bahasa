@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">

        <div class="dashboard__content-title d-flex justify-content-between">
            <h4 class="title">{{ __('Create Course') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                @include('frontend.instructor-dashboard.course.navigation')
                <div class="instructor__profile-form-wrap">
                    <form action="{{ route('instructor.courses.store', ['id' => @$course?->id]) }}"
                        class="instructor__profile-form course-form">
                        @csrf
                        <input type="hidden" name="step" value="1">
                        <input type="hidden" name="next_step" value="2">
                        <input type="hidden" name="edit_mode"
                            value="{{ isset($editMode) && $editMode == true ? true : false }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="title">{{ __('Title') }} <code>*</code></label>
                                    <input id="title" name="title" type="text" value="{{ @$course?->title }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="seo_description">{{ __('Seo description') }} <code></code></label>
                                    <input id="seo_description" name="seo_description" type="text"
                                        value="{{ @$course?->seo_description }}"
                                        placeholder="{{ __('150 - 160 characters recommended') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="from-group mb-3">
                                    <label class="form-file-manager-label" for="">{{ __('Thumbnail') }}
                                        <code>*</code></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <a data-input="thumbnail" data-preview="holder" class="file-manager-image">
                                                <i class="fa fa-picture-o"></i> {{ __('Choose') }}
                                            </a>
                                        </span>
                                        <input id="thumbnail" readonly class="form-control file-manager-input"
                                            type="text" name="thumbnail" value="{{ @$course?->thumbnail }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label for="demo_video_storage">{{ __('Demo Video Storage') }}
                                        <code>({{ __('optional') }})</code></label>
                                    <select name="demo_video_storage" id="demo_video_storage" class="form-select">
                                        <option @selected(@$course?->demo_video_storage == 'upload') value="upload">{{ __('upload') }}</option>
                                        <option @selected(@$course?->demo_video_storage == 'youtube') value="youtube">{{ __('youtube') }}</option>
                                        <option @selected(@$course?->demo_video_storage == 'vimeo') value="vimeo">{{ __('vimeo') }}</option>
                                        <option @selected(@$course?->demo_video_storage == 'external_link') value="external_link">
                                            {{ __('external_link') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 upload {{ @$course?->demo_video_storage == 'upload' ? '' : 'd-none' }}">
                                <div class="from-group mb-3">
                                    <label class="form-file-manager-label" for="">{{ __('Path') }}
                                        <code></code></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <a data-input="path" data-preview="holder" class="file-manager">
                                                <i class="fa fa-picture-o"></i> {{ __('Choose') }}
                                            </a>
                                        </span>
                                        <input id="path" readonly class="form-control file-manager-input"
                                            type="text" name="upload_path" value="{{ @$course?->demo_video_source }}">
                                    </div>
                                </div>
                            </div>

                            <div
                                class="col-md-6 external_link {{ @$course?->demo_video_storage != 'upload' ? '' : 'd-none' }}">
                                <div class="form-grp">
                                    <label for="meta_description">{{ __('Path') }} <code></code></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-link"></i></span>
                                        <input type="text" class="form-control" name="external_path"
                                            placeholder="{{ __('peste your external link') }}"
                                            value="{{ @$course?->demo_video_source }}">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label for="price">{{ __('Price') }} <code>*</code></label>
                                    <input id="price" name="price" type="text" value="{{ @$course?->price }}">
                                    <code>{{ __('Put 0 for free') }}</code>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label for="discount_price">{{ __('Discount Price') }} <code></code></label>
                                    <input id="discount_price" name="discount_price" type="text"
                                        value="{{ @$course?->discount_price }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="description">{{ __('Description') }} <code></code></label>
                                    <textarea name="description" class="text-editor">{!! clean(@$course?->description) !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/default/courses.js') }}"></script>
@endpush
