@extends('admin.master_layout')
@section('title')
    <title>{{ __('Crediential Setting') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Crediential Setting') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Crediential Setting') }}</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills flex-column" id="credientialTab" role="tablist">
                                    @include('globalsetting::credientials.tabs.navbar')
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent2">
                                    @include('globalsetting::credientials.sections.google-recaptcha')
                                    @include('globalsetting::credientials.sections.facebook-pixel')
                                    @include('globalsetting::credientials.sections.social-login')
                                    @include('globalsetting::credientials.sections.tawk-chat')
                                    @include('globalsetting::credientials.sections.google-tag')
                                    @include('globalsetting::credientials.sections.google-analytic')
                                    @include('globalsetting::credientials.sections.wasabi')
                                    @include('globalsetting::credientials.sections.aws')
                                </div>
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
        $(document).ready(function() {
            "use strict";
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#credientialTab a[href="#' + activeTab + '"]').tab('show');
            } else {
                $('#credientialTab a:first').tab('show');
            }

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var newTab = $(e.target).attr('href').substring(1);
                localStorage.setItem('activeTab', newTab);
            });

            $('#copyButton').on('click', function() {
                var copyText = $('#gmail_redirect_url');
                copyText.select();
                document.execCommand('copy');
                toastr.success("{{ __('Copied to clipboard') }}");
            });
        });
    </script>
@endpush
