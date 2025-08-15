@extends('admin.master_layout')
@section('title')
    <title>{{ __('Featured Course Section') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Featured Course Section') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Update Featured courses') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Update featured courses') }}</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.featured-course-section.update', 1) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('All Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="all_category" class="form-control" readonly>
                                                    <option value="0">{{ __('All Category Courses') }}</option>
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Select Courses') }}<span
                                                        class="text-danger"></span></label>
                                                @php
                                                    $allCoursesIds = json_decode($featured?->all_category_ids ? $featured->all_category_ids : '[]');
                                                @endphp
                                                <select name="all_category_ids[]" class="form-control select2" multiple>
                                                    @foreach ($allCourses as $course)
                                                        <option @selected(in_array($course->id, $allCoursesIds)) value="{{ $course->id }}">
                                                            {{ $course->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <hr class="col-md-12">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Category one') }}<span
                                                        class="text-danger"></span></label>

                                                <select name="category_one" class="form-control select2 category"
                                                    data-for="course_ids_one">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option @selected($featured?->category_one == $category->id) value="{{ $category->id }}">
                                                            {{ $category->translation->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_one')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @php
                                                    $id = $featured?->category_one;
                                                    $courses = \App\Models\Course::select('id', 'title')
                                                        ->whereHas('category', function ($query) use ($id) {
                                                            $query->whereHas('parentCategory', function ($query) use (
                                                                $id,
                                                            ) {
                                                                $query->where('id', $id);
                                                            });
                                                        })
                                                        ->get();
                                                    $coursesIds = json_decode($featured?->category_one_ids);
                                                @endphp

                                                <label for="name">{{ __('Select Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_one_ids[]"
                                                    class="form-control select2 course_ids_one" multiple>
                                                    @foreach ($courses as $course)
                                                        <option @selected(in_array($course->id, $coursesIds)) value="{{ $course->id }}">
                                                            {{ $course->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_one_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Status') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_one_status" class="form-control">
                                                    <option @selected($featured?->category_one_status == 1) value="1">{{ __('Active') }}</option>
                                                    <option @selected($featured?->category_one_status == 0) value="0">{{ __('Inactive') }}</option>
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="col-md-12">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Category Two') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_two" class="form-control select2 category"
                                                    data-for="course_ids_two">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option @selected($featured?->category_two == $category->id) value="{{ $category->id }}">
                                                            {{ $category->translation->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_two')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            @php
                                                $id = $featured?->category_two;
                                                $courses = \App\Models\Course::select('id', 'title')
                                                    ->whereHas('category', function ($query) use ($id) {
                                                        $query->whereHas('parentCategory', function ($query) use ($id) {
                                                            $query->where('id', $id);
                                                        });
                                                    })
                                                    ->get();
                                                $coursesIds = json_decode($featured?->category_two_ids);
                                            @endphp

                                            <div class="form-group">
                                                <label for="name">{{ __('Select Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_two_ids[]"
                                                    class="form-control select2 course_ids_two" multiple>
                                                    @foreach ($courses as $course)
                                                        <option @selected(in_array($course->id, $coursesIds)) value="{{ $course->id }}">
                                                            {{ $course->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_two_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Status') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_two_status" class="form-control">
                                                    <option @selected($featured?->category_two_status == 1) value="1">{{ __('Active') }}</option>
                                                    <option @selected($featured?->category_two_status == 0) value="0">{{ __('Inactive') }}</option>
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="col-md-12">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Category Three') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_three" class="form-control select2 category"
                                                    data-for="course_ids_three">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option @selected($featured?->category_three == $category->id) value="{{ $category->id }}">
                                                            {{ $category->translation->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_three')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            @php
                                                $id = $featured?->category_three;
                                                $courses = \App\Models\Course::select('id', 'title')
                                                    ->whereHas('category', function ($query) use ($id) {
                                                        $query->whereHas('parentCategory', function ($query) use ($id) {
                                                            $query->where('id', $id);
                                                        });
                                                    })
                                                    ->get();
                                                $coursesIds = json_decode($featured?->category_three_ids);
                                            @endphp
                                            <div class="form-group">
                                                <label for="name">{{ __('Select Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_three_ids[]"
                                                    class="form-control select2 course_ids_three" multiple>
                                                    @foreach ($courses as $course)
                                                        <option @selected(in_array($course->id, $coursesIds)) value="{{ $course->id }}">
                                                            {{ $course->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_three_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Status') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_three_status" class="form-control">
                                                    <option @selected($featured?->category_three_status == 1) value="1">{{ __('Active') }}</option>
                                                    <option @selected($featured?->category_three_status == 0) value="0">{{ __('Inactive') }}</option>
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="col-md-12">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Category Four') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_four" class="form-control select2 category"
                                                    data-for="course_ids_four">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option @selected($featured?->category_four == $category->id) value="{{ $category->id }}">
                                                            {{ $category->translation->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_four')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            @php
                                                $id = $featured?->category_four;
                                                $courses = \App\Models\Course::select('id', 'title')
                                                    ->whereHas('category', function ($query) use ($id) {
                                                        $query->whereHas('parentCategory', function ($query) use ($id) {
                                                            $query->where('id', $id);
                                                        });
                                                    })
                                                    ->get();
                                                $coursesIds = json_decode($featured?->category_four_ids);
                                            @endphp
                                            <div class="form-group">
                                                <label for="name">{{ __('Select Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_four_ids[]"
                                                    class="form-control select2 course_ids_four" multiple>
                                                    @foreach ($courses as $course)
                                                        <option @selected(in_array($course->id, $coursesIds)) value="{{ $course->id }}">
                                                            {{ $course->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_four_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Status') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_four_status" class="form-control">
                                                    <option @selected($featured?->category_four_status == 1) value="1">{{ __('Active') }}</option>
                                                    <option @selected($featured?->category_four_status == 0) value="0">{{ __('Inactive') }}</option>
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="col-md-12">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Category Five') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_five" class="form-control select2 category"
                                                    data-for="course_ids_five">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option @selected($featured?->category_five == $category->id) value="{{ $category->id }}">
                                                            {{ $category->translation->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_five')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            @php
                                                $id = $featured?->category_five;
                                                $courses = \App\Models\Course::select('id', 'title')
                                                    ->whereHas('category', function ($query) use ($id) {
                                                        $query->whereHas('parentCategory', function ($query) use ($id) {
                                                            $query->where('id', $id);
                                                        });
                                                    })
                                                    ->get();
                                                $coursesIds = json_decode($featured?->category_five_ids);
                                            @endphp
                                            <div class="form-group">
                                                <label for="name">{{ __('Select Courses') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_five_ids[]"
                                                    class="form-control select2 course_ids_five" multiple>
                                                    @foreach ($courses as $course)
                                                        <option @selected(in_array($course->id, $coursesIds)) value="{{ $course->id }}">
                                                            {{ $course->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_five_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Status') }}<span
                                                        class="text-danger"></span></label>
                                                <select name="category_five_status" class="form-control">
                                                    <option @selected($featured?->category_five_status == 1) value="1">{{ __('Active') }}</option>
                                                    <option @selected($featured?->category_five_status == 0) value="0">{{ __('Inactive') }}</option>
                                                </select>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="col-md-12">

                                        <div class="text-center offset-md-2 col-md-8">
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

@push('js')
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        'use strict';
        $(function() {
            $('.category').on('change', function() {
                var selector = $(this).data('for');
                var id = $(this).val();

                $.ajax({
                    method: "get",
                    url: "{{ url('/admin/courses-by-category') }}" + "/" + id,
                    success: function(data) {
                        $("." + selector).empty();
                        let html = '';
                        data.forEach(element => {
                            html +=
                                `<option value="${element.id}">${element.title}</option>`
                        })
                        $("." + selector).html(html);
                    },
                    error: function(xhr, status, error) {}
                })
            })
        });
    </script>
@endpush
