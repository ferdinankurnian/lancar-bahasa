@extends('admin.master_layout')
@section('title')
    <title>{{ __('Review Details') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">{{ __('Review Details') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Review Details') }}</div>
                </div>
            </div>

            <a href="{{ route('admin.course-review.index') }}" class="btn btn-primary">{{ __('Review List') }}</a>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Details') }}</h4>
                                <div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('Course') }}</td>
                                            <td>{{ $review->course->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Rating') }}</td>
                                            <td>
                                                @for ($i = 0; $i < $review->rating; $i++)
                                                    <i class="fa fa-star text-warning"></i>
                                                @endfor
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Review') }}</td>
                                            <td>{{ $review->review }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Date') }}</td>
                                            <td>{{ formatDate($review->created_at) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Status') }}</td>
                                            <td>
                                                <form action="{{ route('admin.course-review.update', $review->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="d-flex">
                                                     
                                                            <select name="status" id="" class="form-control w-25">
                                                                <option @selected($review->status == 0) value="0">{{ __('Pending') }}</option>
                                                                <option @selected($review->status == 1) value="1">{{ __('Approved') }}</option>
                                                            </select>
                                                       
                                                        <div><button type="submit"
                                                            class="btn btn-primary ml-2 mt-1">{{ __('Update') }}</button></div>
                                                    </div>
                                                   
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
