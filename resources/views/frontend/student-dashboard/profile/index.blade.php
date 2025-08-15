@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Settings') }}</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard__nav-wrap">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('profile_tab') == 'profile' ? 'active' : '' }}" id="itemOne-tab" data-bs-toggle="tab"
                                data-bs-target="#itemOne-tab-pane" type="button" role="tab"
                                aria-controls="itemOne-tab-pane" aria-selected="true">{{ __('Profile') }}</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('profile_tab') == 'bio' ? 'active' : '' }}" id="itemFour-tab" data-bs-toggle="tab"
                                data-bs-target="#itemFour-tab-pane" type="button" role="tab"
                                aria-controls="itemFour-tab-pane" aria-selected="true">{{ __('Biography') }}</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('profile_tab') == 'location' ? 'active' : '' }}" id="itemSix-tab" data-bs-toggle="tab"
                                data-bs-target="#itemSix-tab-pane" type="button" role="tab"
                                aria-controls="itemSix-tab-pane" aria-selected="true">{{ __('Location') }}</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('profile_tab') == 'password' ? 'active' : '' }}" id="itemTwo-tab" data-bs-toggle="tab"
                                data-bs-target="#itemTwo-tab-pane" type="button" role="tab"
                                aria-controls="itemTwo-tab-pane" aria-selected="false">{{ __('Password') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('profile_tab') == 'social' ? 'active' : '' }}" id="itemThree-tab" data-bs-toggle="tab"
                                data-bs-target="#itemThree-tab-pane" type="button" role="tab"
                                aria-controls="itemThree-tab-pane" aria-selected="false">{{ __('Social') }}</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    @include('frontend.student-dashboard.profile.sections.profile')

                    @include('frontend.student-dashboard.profile.sections.biography')

                    @include('frontend.student-dashboard.profile.sections.password')

                    @include('frontend.student-dashboard.profile.sections.location')

                    @include('frontend.student-dashboard.profile.sections.social')
                </div>
            </div>
        </div>
    </div>
@endsection
