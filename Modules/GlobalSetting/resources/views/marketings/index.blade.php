@extends('admin.master_layout')
@section('title')
    <title>{{ __('Marketing Settings') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Marketing Settings') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Marketing Settings') }}</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills flex-column" id="marketingTab" role="tablist">
                                    @include('globalsetting::marketings.tabs.navbar')
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent2">
                                    @include('globalsetting::marketings.sections.data-layer')
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
                $('#marketingTab a[href="#' + activeTab + '"]').tab('show');
            } else {
                $('#marketingTab a:first').tab('show');
            }

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var newTab = $(e.target).attr('href').substring(1);
                localStorage.setItem('activeTab', newTab);
            });
        });
    </script>
@endpush
