@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap dashboard__content-wrap-two">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Earnings') }}</h4>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count" data-count="">{{ currency(userAuth()->wallet_balance) }}</span>
                        <p>{{ __('Current Balance') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count">{{ $totalCourseSold }}</span>
                        <p>{{ __('Courses Sold') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count">{{ currency($totalWithdraw) }}</span>
                        <p>{{ __('Total Payout') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard__content-wrap mt-3">
        <div class="dashboard__content-title d-flex flex-wrap justify-content-between">
            <h4 class="title">{{ __('Payout History') }}</h4>
            <a href="{{ route('instructor.payout.create') }}" class="btn btn-primary btn-hight-basic">
                {{ __('Request Payout') }}
            </a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Withdraw Amount') }}</th>
                                <th>{{ __('Method') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawRequests as $key => $withdrawRequest)
                                <tr>
                                    <td>
                                        <p>{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p>{{ currency($withdrawRequest->withdraw_amount) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $withdrawRequest->method }}</p>
                                    </td>
                                    <td>
                                        @if ($withdrawRequest->status == 'approved')
                                            <span class="badge bg-success">{{ __('Approved') }}</span>
                                        @elseif($withdrawRequest->status == 'rejected')
                                            <span class="badge bg-danger">{{ __('Rejected') }}</span>
                                        @elseif($withdrawRequest->status == 'pending')
                                            <span class="badge bg-warning">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p>{{ formatDate($withdrawRequest->created_at) }}</p>
                                    </td>

                                    <td>
                                        @if ($withdrawRequest->status == 'pending')
                                            <p><a href="{{ route('instructor.payout.destroy', $withdrawRequest->id) }}"
                                                    class="text-danger delete-item"><i class="fas fa-trash-alt"></i></a></p>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <td class="text-center" colspan="100">{{ __('No Data') }}</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
