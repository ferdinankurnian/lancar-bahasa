@extends('admin.master_layout')
@section('title')
    <title>{{__('Menu Builder')}}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <div id="loader" class="LoadingOverlay d-none">
            <div class="Line-Progress">
                <div class="indeterminate"></div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Menu Builder') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('menubuilder::menu-builder')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('backend/menubuilder/style.css')}}">
    <style>
        #hwpwrap .spinner {
            background: url("{{asset('backend/menubuilder/images/spinner.gif')}}") 0 0/20px 20px no-repeat;
        }
        @media print, (-o-min-device-pixel-ratio: 5 / 4), (-webkit-min-device-pixel-ratio: 1.25), (min-resolution: 120dpi) {
            #hwpwrap .spinner {
                background-image: url("{{asset('backend/menubuilder/images/spinner-2x.gif')}}");
            }
        }
    </style>
@endpush
@push('js')
    @include('menubuilder::script')
@endpush
