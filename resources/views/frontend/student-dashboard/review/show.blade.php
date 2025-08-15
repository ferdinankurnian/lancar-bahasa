@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
<a href="{{ route('student.reviews.index') }}" class="btn mb-3">{{ __('My Reviews') }}</a>
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Review Details') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
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
                                    @if ($review->status == 1)
                                        <div class="badge bg-success">{{ __('Approved') }}</div>
                                    @else
                                        <div class="badge bg-warning">{{ __('Pending') }}</div>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
