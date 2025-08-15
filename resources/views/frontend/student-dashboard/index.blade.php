@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    @if (instructorStatus() == 'pending')
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <svg 0 16 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 16" role="img" aria-label="Warning:">
                <path 0 1 2 8
                    d="M8.982 1.566a1.13 1.13 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 .954.462.9.995l-.35 3.507a.552.552 1-1.1 0L7.1 5.995A.905.905 5zm.002 6a1 0-2z" />
                </path>
            </svg>
            <div>
                {{ __('We received your request to become instructor') }}. {{ __('Please wait for admin approval') }}!
            </div>
        </div>
    @elseif (instructorStatus() == 'rejected')
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg 0 16 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 16" role="img"
                aria-label="Warning:">
                <path 0 1 2 8
                    d="M8.982 1.566a1.13 1.13 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 .954.462.9.995l-.35 3.507a.552.552 1-1.1 0L7.1 5.995A.905.905 5zm.002 6a1 0-2z" />
                </path>
            </svg>
            <div>
                {{ __('Your request to become instructor has been rejected. Please resubmit your request with valid information') }}
                <a href="{{ route('become-instructor') }}">{{ __('here') }}</a>
            </div>
        </div>
    @endif


    <div class="dashboard__content-wrap dashboard__content-wrap-two mb-60">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Dashboard') }}</h4>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalEnrolledCourses }}"></span>
                        <p>{{ __('ENROLLED COURSES') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalQuizAttempts }}"></span>
                        <p>{{ __('QUIZ ATTEMPTS') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalReviews }}"></span>
                        <p>{{ __('YOUR TOTAL REVIEWS') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Order History') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Invoice') }}</th>
                                <th>{{ __('Paid') }}</th>
                                <th>{{ __('Gateway') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Payment') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($orders as $index => $order)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>#{{ $order->invoice_id }}</td>
                                    <td>{{ $order->paid_amount }} {{ $order->payable_currency }}</td>
                                    <td>
                                        {{ $order->payment_method }}
                                    </td>
                                    <td>
                                        @if ($order->status == 'completed')
                                            <div class="badge bg-success">{{ __('Completed') }}</div>
                                        @elseif($order->status == 'processing')
                                            <div class="badge bg-warning">{{ __('Processing') }}</div>
                                        @elseif($order->status == 'declined')
                                            <div class="badge bg-danger">{{ __('Declined') }}</div>
                                        @else
                                            <div class="badge bg-warning">{{ __('Pending') }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <div class="badge bg-success">{{ __('Paid') }}</div>
                                        @elseif ($order->payment_status == 'cancelled')
                                            <div class="badge bg-danger">{{ __('Cancelled') }}</div>
                                        @else
                                            <div class="badge bg-danger">{{ __('Pending') }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('student.order.show', $order->id) }}" class=""><i
                                                class="fa fa-eye"></i></a>
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
            </div>
        </div>
    </div>
@endsection
