@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('My Reviews') }}</h4>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('Rating') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($reviews as $index => $review)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $review->course->title }}</td>
                                    <td>
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                    </td>

                                    <td>
                                        @if ($review->status == 1)
                                            <div class="badge bg-success">{{ __('Approved') }}</div>
                                        @else
                                            <div class="badge bg-warning">{{ __('Pending') }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('student.reviews.show', $review->id) }}" class="text-primary"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="{{ route('student.reviews.destroy', $review->id) }}" class="text-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">{{ __('No orders found!') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection
