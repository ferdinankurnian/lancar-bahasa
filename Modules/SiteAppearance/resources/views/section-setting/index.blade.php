@extends('admin.master_layout')
@section('title')
    <title>{{ __('Section Settings') }}</title>
@endsection

@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Section Settings') }}</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.section-setting.update', 1) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Hero Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->hero_section) type="checkbox" name="hero_section"
                                                value="1" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Top Category Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->top_category_section) type="checkbox" name="top_category_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Brands Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->brands_section) type="checkbox" name="brands_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('About Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->about_section) type="checkbox" name="about_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Featured Course Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->featured_course_section) type="checkbox" name="featured_course_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('News Letter Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->news_letter_section) type="checkbox" name="news_letter_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Featured Instructor Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->featured_instructor_section) type="checkbox" name="featured_instructor_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Counter Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->counter_section) type="checkbox" name="counter_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Faq Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->faq_section) type="checkbox" name="faq_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Our Features Section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->our_features_section) type="checkbox" name="our_features_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Banner section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->banner_section) type="checkbox" name="banner_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Testimonial section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->testimonial_section) type="checkbox" name="testimonial_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('Latest Blog section') }}</div>
                                        <label class="custom-switch mt-2">
                                            <input @checked($sectionSetting?->latest_blog_section) type="checkbox" name="latest_blog_section" value="1"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
@endpush
