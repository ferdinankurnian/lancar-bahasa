@extends('admin.master_layout')
@section('title')
    <title>{{ __('Course Language') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Language') }}</h1>
            </div>

            <div class="section-body">
                <a href="{{ route('admin.course-language.index') }}" class="btn btn-primary"><i class="fas fa-list"></i>
                    {{ __('Course Language List') }}</a>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course-language.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-12">
                                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Flag') }}</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
