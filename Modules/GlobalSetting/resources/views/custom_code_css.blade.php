@extends('admin.master_layout')
@section('title')
    <title>{{ __('Custom CSS') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Custom CSS') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Custom CSS') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="border rounded">
                                        <div class="m-0 card">
                                            <div class="card-body">
                                                <form action="{{ route('admin.update-custom-code') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">{{ __('Custom CSS') }} <span data-toggle="tooltip" data-placement="top"
                                                                    class="fa fa-info-circle text--primary"
                                                                    title="{{ __('Write your css code here without the style tag') }}"></span></label>
                                                                <textarea name="css" id="css-editor" cols="30" rows="5" class="form-control text-area-5">{{ old('css', $customCode->css) }}</textarea>
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
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/codemirror/codemirror.css') }}">
@endpush

@push('js')
    <script src="{{ asset('backend/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('backend/codemirror/css.js') }}"></script>

    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById('css-editor'), {
            mode: "css",
            lineNumbers: true,
            lineWrapping: true,
            autocorrect: true,
        });
        editor.save()
    </script>
@endpush