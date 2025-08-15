@extends('admin.master_layout')
@section('title')
    <title>{{ __('Request Details') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Request Details') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card shadow">
                            @if ($user->image)
                                <img src="{{ asset($user->image) }}" class="profile_img w-100">
                            @else
                                <img src="{{ asset($setting->default_avatar) }}" class="w-100">
                            @endif
                            <hr>
                            <div class="container my-3">
                                <h4>{{ html_decode($user->name) }}</h4>

                                @if ($user->phone)
                                    <p class="title">{{ html_decode($user->phone) }}</p>
                                @endif

                                <p class="title">{{ html_decode($user->email) }}</p>

                                <p class="title">{{ __('Joined') }} : {{ $user->created_at->format('h:iA, d M Y') }}</p>


                                @if ($user->email_verified_at)
                                    <p class="title">{{ __('Email verified') }} : <b>{{ __('Yes') }}</b> </p>
                                @else
                                    <p class="title">{{ __('Email verified') }} : <b>{{ __('NO') }}</b> </p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        {{-- information card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Informations') }}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>{{ __('Status') }}</b></td>
                                            <td>
                                                @if ($instructorRequest->status == 'pending')
                                                    <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                @elseif ($instructorRequest->status == 'approved')
                                                    <span class="badge badge-success">{{ __('Approved') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($instructorRequest->certificate)
                                            <tr>
                                                <td><b>{{ __('Certificate / Document') }}</b></td>
                                                <td><a target="_blank" href="{{ asset($instructorRequest->certificate) }}"
                                                        class="btn btn-primary">{{ __('Download') }}</a></td>
                                            </tr>
                                        @endif

                                        @if ($instructorRequest->identity_scan)
                                            <tr>
                                                <td><b>{{ __('Identity Scan') }}</b></td>
                                                <td><a target="_blank"
                                                        href="{{ asset($instructorRequest->identity_scan) }}"
                                                        class="btn btn-primary">{{ __('Download') }}</a></td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td><b>{{ __('Extra Informations') }}</b></td>
                                            <td>{{ $instructorRequest->extra_information }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Payment information card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Payout Informations') }}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>{{ __('Payout Account') }}</b></td>
                                            <td>{{ $instructorRequest->payout_account }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>{{ __('Payout Details') }}</b></td>
                                            <td>{!! nl2br(clean($instructorRequest->payout_information)) !!}</td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- information card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Informations') }}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>{{ __('Update Status') }}</b></td>
                                            <td>
                                                <form action="{{ route('admin.instructor-request.update', $instructorRequest->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mt-3">
                                                        <select name="status" class="form-control">
                                                            <option @selected($instructorRequest->status == 'pending') value="pending">
                                                                {{ __('Pending') }}</option>
                                                            <option @selected($instructorRequest->status == 'approved') value="approved">
                                                                {{ __('Approved') }}</option>
                                                            <option @selected($instructorRequest->status == 'rejected') value="rejected">
                                                                {{ __('Rejected') }}</option>
                                                        </select>
                                                        <button class="btn btn-success mt-2"
                                                            type="submit">{{ __('Update') }}</button>
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
