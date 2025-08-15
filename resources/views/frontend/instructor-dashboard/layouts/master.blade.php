@extends('frontend.layouts.master')

<!-- meta -->
@section('meta_title', __('Instructor Dashboard'))
<!-- end meta -->

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('')" :links="[]" />
    <!-- breadcrumb-area-end -->

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120">
        <div class="container">
            <div class="dashboard__top-wrap">
                <div class="dashboard__top-bg" data-background="{{ asset(auth()->user()->cover) }}"></div>
                <div class="dashboard__instructor-info">
                    <div class="dashboard__instructor-info-left">
                        <div class="thumb">
                            <img src="{{ asset(auth()->user()->image) }}" alt="img">
                        </div>
                        <div class="content">
                            <h4 class="title">{{ auth()->user()->name }}</h4>
                            <ul class="list-wrap">
                                <li>
                                    <img src="{{ asset('frontend/img/icons/envelope.svg') }}" alt="img"
                                        class="injectable">
                                    {{ auth()->user()->email }}
                                </li>
                                @if (auth()->user()->phone)
                                    <li>
                                        <img src="{{ asset('frontend/img/icons/phone.svg') }}" alt="img"
                                            class="injectable">
                                        {{ auth()->user()->phone }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="dashboard__instructor-info-right">
                        <a href="{{ route('student.dashboard') }}" class="btn btn-two arrow-btn">{{ __('Student Dashboard') }} <img
                            src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.instructor-dashboard.layouts.sidebar')
                </div>
                <div class="col-lg-9 position-relative">
                    <div class="preloader d-none">
                        <div class="loader-icon"><img src="{{ asset(Cache::get('setting')->preloader) }}" alt="Preloader">
                        </div>
                    </div>

                    @yield('dashboard-contents')
                </div>
            </div>
        </div>
    </section>
    <!-- dashboard-area-end -->
@endsection
