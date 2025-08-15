@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap dashboard__content-wrap-two">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Earnings') }}</h4>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div>
                      {{ __('You can change your payment method informations from your profile settings.') }}
                    </div>
                  </div>
            </div>
              
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

    <div class="dashboard__content-wrap dashboard__content-wrap-two mt-3">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Create a Request') }}</h4>
        </div>
        <form action="{{ route('instructor.payout.store') }}" method="POST" class="instructor__profile-form">
            @csrf
            <table class="table table-bordered">
                <tr>
                    <td>{{ __('Default Gateway') }}</td>
                    <td>{{ $gateway->payout_account }}</td>
                </tr>
                <tr>
                    <td>{{ __('Minimum Payout') }}</td>
                    <td>{{ currency($withdrawMethod->min_amount) }}</td>
                </tr>

                <tr>
                    <td>{{ __('Maximum Payout') }}</td>
                    <td>{{ currency($withdrawMethod->max_amount) }}</td>
                </tr>
                <tr>
                    <td>{{ __('Gateway Information') }}</td>
                    <td>
                        {!! nl2br(clean($gateway->payout_information)) !!}
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="phone">{{ __('Withdraw Amount') }}</label>
                        <input id="phone" name="amount" type="text" value="{{ old('amount') }}">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn">{{ __('Request Payout') }}</button>
            </div>
        </form>

    </div>
@endsection
