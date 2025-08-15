@extends('frontend.layouts.master')

<!-- meta -->
@section('meta_title', __('Student Dashboard'))
<!-- end meta -->

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb
        :title="__('')"
        :links="[]"
    />
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
                                    <img src="{{ asset('frontend/img/icons/envelope.svg') }}" alt="img" class="injectable">
                                    {{ auth()->user()->email }}
                                </li>
                                @if(auth()->user()->phone)
                                <li>
                                    <img  src="{{ asset('frontend/img/icons/phone.svg') }}" alt="img" class="injectable">
                                    {{ auth()->user()->phone }}
                                </li>
                                @endif
                                
                            </ul>
                        </div>
                    </div>
                    <div class="dashboard__instructor-info-right">
                        @if (instructorStatus() == 'approved')
                        <a href="{{ route('instructor.dashboard') }}" class="btn btn-two arrow-btn">{{ __('Instructor Dashboard') }} <img
                            src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                        @elseif (instructorStatus() != 'pending')
                        <a href="{{ route('become-instructor') }}" class="btn btn-two arrow-btn">{{ __('Become an Instructor') }} <img
                            src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.student-dashboard.layouts.sidebar')
                </div>
                <div class="col-lg-9">
                    @yield('dashboard-contents')
                </div>
            </div>
        </div>
    </section>
    <!-- dashboard-area-end -->
@endsection
