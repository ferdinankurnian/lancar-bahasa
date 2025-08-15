@extends('admin.master_layout')
@section('title')
    <title>{{ __('Manage Language') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.languages.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Manage Language') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.languages.index') }}">{{ __('Manage Language') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Create Language') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Create Language') }}</h4>
                                <div>
                                    <a href="{{ route('admin.languages.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.languages.store') }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="offset-md-3 col-md-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }}</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="{{ __('Enter Name') }}" value="{{ old('name') }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-3 col-md-6">
                                            <div class="form-group">
                                                <label for="code">{{ __('Code') }}</label>
                                                <select class="form-control select2" name="code" id="code">
                                                    <option value="">{{ __('Select language') }}</option>
                                                    @foreach ($all_languages as $language)
                                                        <option value="{{ $language->code }}" @selected(old('code') == $language->code)>
                                                            {{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-3 col-md-6">
                                            <div class="form-group">
                                                <label for="image">{{ __('Flag') }}</label>
                                                <input type="file" class="form-control" name="image" id="image">
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center offset-md-3 col-md-6">
                                            <x-admin.save-button :text="__('Save')" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

