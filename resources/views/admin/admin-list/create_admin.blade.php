@extends('admin.master_layout')
@section('title')
    <title>{{ __('Add Admin') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.admin.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Add Admin') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.admin.index') }}">{{ __('Manage Admin') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Add Admin') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3>{{ __('Add Admin') }}</h3>
                                <div>
                                    @adminCan('admin.view')
                                        <a href="{{ route('admin.admin.index') }}" class="btn btn-primary"><i
                                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                                    @endadminCan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <form action="{{ route('admin.admin.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" id="name" class="form-control"
                                                        name="name">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>{{ __('Email') }} <span class="text-danger">*</span></label>
                                                    <input type="email" id="slug" class="form-control"
                                                        name="email">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                                                    <input type="password" id="password" class="form-control"
                                                        name="password">
                                                </div>

                                                <div class="form-group col-12">
                                                    <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control">
                                                        <option value="active">{{ __('Active') }}</option>
                                                        <option value="inactive">{{ __('Inactive') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="role">{{ __('Assign Role') }} <span
                                                            class="text-danger">*</span></label>
                                                    <select name="role[]" id="role"
                                                        class="form-control select2 @error('role') is-invalid @enderror"
                                                        multiple>
                                                        <option value="" disabled>{{ __('Select Role') }}</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="text-center col-md-8 offset-md-2">
                                                    <x-admin.save-button :text="__('Save')"></x-admin.save-button>
                                                </div>
                                            </div>
                                        </form>
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
