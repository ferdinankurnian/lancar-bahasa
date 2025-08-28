@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap dashboard__content-wrap-two mb-60">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Dashboard') }}</h4>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalCourses }}"></span>
                        <p>{{ __('TOTAL COURSES') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalPendingCourses }}"></span>
                        <p>{{ __('PENDING COURSES') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalOrders }}"></span>
                        <p>{{ __('TOTAL ORDERS') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalPendingOrders }}"></span>
                        <p>{{ __('PENDING ORDERS') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="content">
                        <span style="font-size: 1.75rem;" class="count" data-count="">{{ currency(userAuth()->wallet_balance) }}</span>
                        <p class="mt-3">{{ __('Current Balance') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="content">
                        <span style="font-size: 1.75rem;" class="count">{{ currency($totalWithdraw) }}</span>
                        <p class="mt-3">{{ __('Total Payout') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
