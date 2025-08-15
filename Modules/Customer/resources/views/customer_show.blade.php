@extends('admin.master_layout')
@section('title')
    <title>{{ __('User Details') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('User Details') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card shadow">
                            @if ($user->image)
                                <img src="{{ asset($user->image) }}" class="profile_img w-100">
                            @else
                                <img src="{{ asset($setting->default_avatar) }}" class="w-100">
                            @endif

                            <div class="container my-3">
                                <h4>{{ html_decode($user->name) }}</h4>

                                @if ($user->phone)
                                    <p class="title">{{ html_decode($user->phone) }}</p>
                                @endif

                                <p class="title">{{ html_decode($user->email) }}</p>

                                <p class="title">{{ __('Joined') }} : {{ $user->created_at->format('h:iA, d M Y') }}</p>

                                @if ($user->is_banned == 'yes')
                                    <p class="title">{{ __('Banned') }} : <b>{{ __('Yes') }}</b></p>
                                @else
                                    <p class="title">{{ __('Banned') }} : <b>{{ __('No') }}</b></p>
                                @endif

                                @if ($user->email_verified_at)
                                    <p class="title">{{ __('Email verified') }} : <b>{{ __('Yes') }}</b> </p>
                                @else
                                    <p class="title">{{ __('Email verified') }} : <b>{{ __('None') }}</b> </p>

                                    <a href="javascript:;" data-toggle="modal" data-target="#verifyModal"
                                        class="btn btn-success my-2">{{ __('Send Verify Link to Mail') }}</a>
                                @endif

                                <a href="javascript:;" data-toggle="modal" data-target="#sendMailModal"
                                    class="btn btn-primary sendMail my-2">{{ __('Send Mail To User') }}</a>

                                @if ($user->is_banned == 'yes')
                                    <a href="javascript:;" data-toggle="modal" data-target="#bannedModal"
                                        class="btn btn-warning my-2">{{ __('Remove Ban') }}</a>
                                @else
                                    <a href="javascript:;" data-toggle="modal" data-target="#bannedModal"
                                        class="btn btn-warning my-2">{{ __('Ban User') }}</a>
                                @endif

                                @if ($user->role != 'instructor')
                                    <a onclick="deleteData({{ $user->id }})" href="javascript:;" data-toggle="modal"
                                        data-target="#deleteModal" class="btn btn-danger">{{ __('Delete Account') }}</a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        {{-- profile information card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Profile Information') }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.customer-info-update', $user->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Full Name') }} <code>*</code></label>
                                                <input id="name" name="name" type="text"
                                                    value="{{ $user->name }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email') }} <code>*</code></label>
                                                <input id="email" name="email" type="email"
                                                    value="{{ $user->email }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('phone') }}</label>
                                                <input id="phone" name="phone" type="text"
                                                    value="{{ $user->phone }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">{{ __('Gender') }}</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="">{{ __('Select') }}</option>
                                                    <option @selected($user->gender == 'male') value="male">{{ __('Male') }}
                                                    </option>
                                                    <option @selected($user->gender == 'female') value="female">{{ __('Female') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="age">{{ __('Age') }}</label>
                                                <input id="age" name="age" type="text"
                                                    value="{{ $user->age }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <button type="submit"
                                                class="btn btn-primary w-100">{{ __('Update Profile') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- change biography card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Profile Biography') }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.customer-bio-update', $user->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="designation">{{ __('Designation') }} <code>*</code></label>
                                                <input id="designation" name="designation" type="text"
                                                    value="{{ $user->job_title }}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="short-bio">{{ __('Short Bio') }} <code>*</code></label>
                                                <textarea id="short-bio" name="short_bio" class="form-control">{{ $user->short_bio }}</textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="bio">{{ __('Bio') }} <code>*</code></label>
                                                <textarea id="bio" name="bio" class="form-control">{{ $user->bio }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <button type="submit"
                                                class="btn btn-primary w-100">{{ __('Update Profile') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if($user->role == 'instructor')
                        {{-- change Education and experience card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Experience and Education') }}</h5>
                            </div>
                            <div class="card-body">
                                <!-- Experience -->
                                <div class="instructor__profile-form-wrap">
                                    <div class="dashboard__content-title d-flex justify-content-between">
                                        <h5 class="title">{{ __('Experience') }}</h5>
                                        <button type="button" class="btn btn-primary btn-hight-basic show-modal mb-3"
                                            data-url="{{ route('admin.customer-experience-modal', $user->id) }}">
                                            {{ __('Add Experience') }}
                                        </button>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="dashboard__review-table table-responsive">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('No') }}</th>
                                                            <th>{{ __('Company') }}</th>
                                                            <th>{{ __('Position') }}</th>
                                                            <th>{{ __('Start Date') }}</th>
                                                            <th>{{ __('End Date') }}</th>
                                                            <th>{{ __('Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($experiences as $experience)
                                                            <tr>
                                                                <td>
                                                                    <p>{{ $loop->iteration }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $experience->company }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $experience->position }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $experience->start_date }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $experience->current ? 'Present' : $experience->end_date }}
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    <div class="dashboard__review-action">
                                                                        <a href="#"
                                                                            class="show-modal btn btn-primary btn-sm m-1"
                                                                            data-url="{{ route('admin.customer-edit-experience-modal', $experience->id) }}"
                                                                            title="Edit"><i
                                                                                class="far fa-edit"></i></i></a>

                                                                        <a href="javascript:;" data-toggle="modal"
                                                                            data-target="#deleteModal"
                                                                            class="btn btn-danger btn-sm m-1"
                                                                            onclick="deleteExperience({{ $experience->id }})"><i
                                                                                class="fa fa-trash"
                                                                                aria-hidden="true"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <td colspan="6" class="text-center">
                                                                <span class="text-muted">{{ __('No Data!') }}</span>
                                                            </td>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <!-- Education -->
                                <div class="instructor__profile-form-wrap">
                                    <div class="dashboard__content-title d-flex justify-content-between">
                                        <h5 class="title">{{ __('Education') }}</h5>
                                        <button type="button" class="btn btn-primary btn-hight-basic show-modal mb-3"
                                            data-url="{{ route('admin.customer-education-modal', $user->id) }}">
                                            {{ __('Add Education') }}
                                        </button>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="dashboard__review-table table-responsive">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('No') }}</th>
                                                            <th>{{ __('Organization') }}</th>
                                                            <th>{{ __('Degree') }}</th>
                                                            <th>{{ __('Start Date') }}</th>
                                                            <th>{{ __('End Date') }}</th>
                                                            <th width="20%">{{ __('Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($educations as $education)
                                                            <tr>
                                                                <td>
                                                                    <p>{{ $loop->iteration }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $education->organization }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $education->degree }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $education->start_date }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $education->current == 1 ||$education->end_date == null ? 'Present' : $experience->end_date }}</p>
                                                                </td>

                                                                <td>
                                                                    <div class="dashboard__review-action">
                                                                        <a href="#"
                                                                            class="show-modal btn btn-primary btn-sm m-1"
                                                                            data-url="{{ route('admin.customer-edit-education-modal', $education->id) }}"
                                                                            title="Edit"><i
                                                                                class="far fa-edit"></i></i></a>
                                                                        <a href="javascript:;" data-toggle="modal"
                                                                            data-target="#deleteModal"
                                                                            class="btn btn-danger btn-sm m-1"
                                                                            onclick="deleteEducation({{ $education->id }})"><i
                                                                                class="fa fa-trash"
                                                                                aria-hidden="true"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <td colspan="6" class="text-center">
                                                                <span class="text-muted">{{ __('No Data!') }}</span>
                                                            </td>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- change biography card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Profile Location') }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.customer-location-update', $user->id) }}" method="POST"
                                    class="instructor__profile-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">{{ __('Country') }} <code>*</code></label>
                                                <select name="country" id="country" class="country form-control">
                                                    <option value="">{{ __('Select') }}</option>
                                                    @foreach (countries() as $country)
                                                        <option @selected($user->country_id == $country->id) value="{{ $country->id }}">
                                                            {{ $country->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-grp">
                                                <label for="state">{{ __('State') }}</label>
                                                <input type="text" class="form-control" name="state" id="state" value="{{ $user->state }}"> 
                                            </div>
                                        </div>
                        
                                        <div class="col-md-4">
                                            <div class="form-grp">
                                                <label for="city">{{ __('City') }}</label>
                                                <input type="text" class="form-control" name="city" id="city" value="{{ $user->city }}">
                                            </div>
                                        </div>
                        

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">{{ __('Address') }}</label>
                                                <input id="address" value="{{ $user->address }}" type="address"
                                                    name="address" placeholder="{{ __('Address') }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary w-100">{{ __('Update Profile') }}</button>

                                </form>
                            </div>
                        </div>

                        {{-- change socials card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Profile Socials') }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.customer-Social-update', $user->id) }}" method="POST" class="instructor__profile-form">
                                    @csrf
                                    @method('PUT')
                                      <div class="form-group">
                                          <label for="facebook">{{ __('Facebook') }}</label>
                                          <input id="facebook" name="facebook" type="url" value="{{ $user->facebook }}" class="form-control">
                                      </div>
                                      <div class="form-group">
                                          <label for="twitter">{{ __('Twitter') }}</label>
                                          <input id="twitter" name="twitter" type="url" value="{{ $user->twitter }}" class="form-control" >
                                      </div>
                                      <div class="form-group">
                                          <label for="linkedin">{{ __('Linkedin') }}</label>
                                          <input id="linkedin" name="linkedin" type="url" value="{{ $user->linkedin }}" class="form-control">
                                      </div>
                                      <div class="form-group">
                                          <label for="website">{{ __('Website') }}</label>
                                          <input id="website" name="website" type="url" value="{{ $user->website }}" class="form-control">
                                      </div>
                                      <div class="form-group">
                                          <label for="github">{{ __('Github') }}</label>
                                          <input id="github" name="github" type="url" value="{{ $user->github }}" class="form-control">
                                      </div>
                                      <div class="submit-btn">
                                          <button type="submit" class="btn btn-primary w-100">{{ __('Update Profile') }}</button>
                                      </div>
                                  </form>
                            </div>
                        </div>


                        {{-- change password card area --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="service_card">{{ __('Change Password') }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.customer-password-change', $user->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">{{ __('Password') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="">{{ __('Confirm Password') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <button type="submit"
                                                class="btn btn-primary w-100">{{ __('Change Password') }}</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- banned history card area --}}
                        @if ($banned_histories->count() > 0)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="service_card">{{ __('Banned History') }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="30%">{{ __('Subject') }}</th>
                                                <th width="30%">{{ __('Description') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($banned_histories as $banned_history)
                                                <tr>
                                                    <td>{{ $banned_history->subject }}</td>
                                                    <td>{!! clean(nl2br($banned_history->description)) !!}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Start Banned modal -->
    <div class="modal fade" id="bannedModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Banned request confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="{{ route('admin.send-banned-request', $user->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="">{{ __('Subject') }}</label>
                                <input type="text" class="form-control" name="subject">
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('Description') }}</label>
                                <textarea name="description" class="form-control text-area-5" id="" cols="30" rows="10"></textarea>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Send Request') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banned modal -->

    <!-- Start Verify modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Send verify link to customer mail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>{{ __('Are you sure want to send verify link to customer mail?') }}</p>

                        <form action="{{ route('admin.send-verify-request', $user->id) }}" method="POST">
                            @csrf

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Send Request') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Verify modal -->

    <!-- Start Send Mail modal -->
    <div class="modal fade" id="sendMailModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Send mail to User') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="{{ route('admin.send-mail-to-customer', $user->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="">{{ __('Subject') }}</label>
                                <input type="text" class="form-control" name="subject">
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('Description') }}</label>
                                <textarea name="description" class="form-control text-area-5" id="" cols="30" rows="10"></textarea>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Send Mail') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Send Mail modal -->

    <x-admin.delete-modal />
    @push('js')
        <script>
            function deleteData(id) {
                $("#deleteForm").attr("action", '{{ url('/admin/customer-delete/') }}' + "/" + id)
            }

            function deleteExperience(id) {
                $("#deleteForm").attr("action", '{{ url('/admin/customer-experience-destroy/') }}' + "/" + id)
            }

            function deleteEducation(id) {
                $("#deleteForm").attr("action", '{{ url('/admin/customer-education-destroy/') }}' + "/" + id)
            }
        </script>
    @endpush

@endsection
