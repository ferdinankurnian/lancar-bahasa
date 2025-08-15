@extends('frontend.layouts.master')
@section('meta_title', $seo_setting['course_page']['seo_title'])
@section('meta_description', $seo_setting['course_page']['seo_description'])

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Courses')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => '', 'text' => __('Courses')]]" />
    <!-- breadcrumb-area-end -->

    <!-- all-courses -->
    <section class="all-courses-area section-py-120 top-baseline">
        <div class="container position-relative">
            <div class="preloader-two d-none">
                <div class="loader-icon-two"><img src="{{ asset(Cache::get('setting')->preloader) }}" alt="Preloader"></div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="courses__sidebar_area">
                        <div class="courses__sidebar_button d-lg-none">
                            <h4>{{ __('filter') }}</h4>
                        </div>
                        <aside class="courses__sidebar">
                            <div class="courses-widget">
                                <h4 class="widget-title">{{ __('Categories') }}</h4>
                                <div class="courses-cat-list">
                                    <ul class="list-wrap">
                                        @foreach ($categories->sortBy('translation.name') as $category)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input main-category-checkbox" type="radio"
                                                        name="main_category" value="{{ $category->slug }}"
                                                        id="cat_{{ $category->id }}">
                                                    <label class="form-check-label"
                                                        for="cat_{{ $category->id }}">{{ $category->translation->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="show-more">
                                    </div>
                                </div>
                            </div>

                            <div class="sub-category-holder "></div>
                            <div class="courses-widget">
                                <h4 class="widget-title">{{ __('Language') }}</h4>
                                <div class="courses-cat-list">
                                    <ul class="list-wrap">

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input language-checkbox" type="checkbox"
                                                    value="" id="lang">
                                                <label class="form-check-label"
                                                    for="lang">{{ __('All Language') }}</label>
                                            </div>
                                        </li>
                                        @foreach ($languages as $language)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input language-checkbox" type="checkbox"
                                                        value="{{ $language->id }}" id="lang_{{ $language->id }}">
                                                    <label class="form-check-label"
                                                        for="lang_{{ $language->id }}">{{ $language->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <div class="show-more">
                                </div>
                            </div>
                            <div class="courses-widget">
                                <h4 class="widget-title">{{ __('Price') }}</h4>
                                <div class="courses-cat-list">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input price-checkbox" type="checkbox"
                                                    value="" id="price_1">
                                                <label class="form-check-label"
                                                    for="price_1">{{ __('All Price') }}</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input price-checkbox" type="checkbox"
                                                    value="free" id="price_2">
                                                <label class="form-check-label" for="price_2">{{ __('Free') }}</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input price-checkbox" type="checkbox"
                                                    value="paid" id="price_3">
                                                <label class="form-check-label" for="price_3">{{ __('Paid') }}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="courses-widget">
                                <h4 class="widget-title">{{ __('Skill level') }}</h4>
                                <div class="courses-cat-list">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input level-checkbox" type="checkbox"
                                                    value="" id="difficulty_1">
                                                <label class="form-check-label"
                                                    for="difficulty_1">{{ __('All Levels') }}</label>
                                            </div>
                                        </li>
                                        @foreach ($levels as $level)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input level-checkbox" type="checkbox"
                                                        value="{{ $level->id }}" id="difficulty_{{ $level->id }}">
                                                    <label class="form-check-label"
                                                        for="difficulty_{{ $level->id }}">{{ $level->translation->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="courses-top-wrap courses-top-wrap">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="courses-top-left">
                                    <p>{{ __('Total') }} <span class="course-count">0</span> {{ __('courses found') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex justify-content-center align-items-center flex-wrap">
                                    <div class="courses-top-right m-0 ms-md-auto">
                                        <span class="sort-by">{{ __('Sort By') }}:</span>
                                        <div class="courses-top-right-select">
                                            <select name="orderby" class="orderby">
                                                <option value="desc">{{ __('Latest to Oldest') }}</option>
                                                <option value="asc">{{ __('Oldest to Latest') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="grid" role="tabpanel"
                            aria-labelledby="grid-tab">
                            <div
                                class="course-holder row courses__grid-wrap row-cols-1 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                                {{-- dynamic content will go here via ajax --}}
                            </div>

                            <div class="pagination-wrap">
                                <div class="pagination">
                                    {{-- dynamic content will go here via ajax --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- all-courses-end -->
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/default/course-page.js') }}"></script>
@endpush
