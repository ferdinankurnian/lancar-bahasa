@extends('admin.master_layout')
@section('title')
    <title>{{ __('Counter Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Counter Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Counter Section') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Update Counter Section') }}</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.counter-section.update', ['code' => $code]) }}"
                                    method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_student">{{ __('Total Students') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_student"
                                                    name="total_student_count"
                                                    value="{{ $counter?->global_content?->total_student_count }}"
                                                    placeholder="{{ __('Total Students') }}" class="form-control">
                                                @error('total_student_count')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_instructors">{{ __('Total Instructors') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_instructors"
                                                    name="total_instructor_count"
                                                    value="{{ $counter?->global_content?->total_instructor_count }}"
                                                    placeholder="{{ __('Total Instructors') }}" class="form-control">
                                                @error('total_instructor_count')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_courses">{{ __('Total Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_courses"
                                                    name="total_courses_count"
                                                    value="{{ $counter?->global_content?->total_courses_count }}"
                                                    placeholder="{{ __('Total Courses') }}" class="form-control">
                                                @error('total_courses_count')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_awards">{{ __('Total Awards') }}<span
                                                        class="text-danger"></span></label>
                                                <input data-translate="true" type="text" id="total_awards"
                                                    name="total_awards_count"
                                                    value="{{ $counter?->global_content?->total_awards_count }}"
                                                    placeholder="{{ __('Total Awards') }}" class="form-control">
                                                @error('Total Awards')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center col">
                                            <x-admin.save-button :text="__('Save')">
                                            </x-admin.save-button>
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
