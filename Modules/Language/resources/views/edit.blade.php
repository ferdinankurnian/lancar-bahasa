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
                    <div class="breadcrumb-item">{{ __('Edit Language') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Edit Language') }}</h4>
                                <div>
                                    <a href="{{ route('admin.languages.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.languages.update', $language->id) }}"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="offset-md-3 col-md-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }}</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="{{ __('Enter Name') }}"
                                                    value="{{ old('name', $language->name) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="offset-md-3 col-md-6">
                                            <div class="form-group">
                                                <label for="code">{{ __('Code') }}</label>
                                                <select class="form-control select2" name="code" id="code">
                                                    <option>{{ __('Select language') }}</option>
                                                    @foreach ($all_languages as $lang)
                                                        <option value="{{ $lang->code }}" @selected(old('code', $language->code) == $lang->code)>
                                                            {{ $lang->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($language->image)
                                            <div class="offset-md-3 col-md-6">
                                                <div class="form-group">
                                                    <label for="image">{{ __('Current Flag') }}</label>
                                                    <div>
                                                        <img src="{{ asset($language->image) }}" alt="flag" width="100">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="offset-md-3 col-md-6">
                                            <div class="form-group">
                                                <label for="image">{{ $language->image ? __('New Flag') : __('Flag') }}</label>
                                                <input type="file" class="form-control" name="image" id="image">
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center offset-md-3 col-md-6">
                                            <x-admin.update-button :text="__('Update')" />
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