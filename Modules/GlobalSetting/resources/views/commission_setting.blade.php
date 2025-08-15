@extends('admin.master_layout')
@section('title')
    <title>{{ __('Commission Setup') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Commission Setup') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Commission Setup') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    <ul class="nav nav-pills flex-column" id="seo_tab" role="tablist">
                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link active" id="error-tab" data-toggle="tab" href="#errorTab"
                                                role="tab" aria-controls="errorTab"
                                                aria-selected="true">{{ __('Commission Setup') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-9">
                                    <div class="border rounded">
                                        <div class="tab-content no-padding" id="settingsContent">
                                            <div class="tab-pane fade show active " id="errorTab" role="tabpanel"
                                                aria-labelledby="error-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('admin.update-commission-setting') }}" method="POST">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('Admin Commission Per Sell (%)') }}</label>
                                                                        <input type="text" name="commission_rate"
                                                                            class="form-control" value="{{ $setting->commission_rate }}">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary">{{ __('Update') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                $('#seo_tab a[href="#' + activeTab + '"]').tab('show');
            } else {
                $('#seo_tab a:first').tab('show');
            }

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var newTab = $(e.target).attr('href').substring(1);
                localStorage.setItem('activeTab', newTab);
            });
        });
    </script>
@endpush
