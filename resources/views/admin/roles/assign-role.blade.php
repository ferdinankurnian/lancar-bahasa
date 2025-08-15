@extends('admin.master_layout')
@section('title')
    <title>{{ __('Assign Role') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.role.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Assign Role') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.role.index') }}">{{ __('Manage Roles') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Assign Role') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Assign Role') }}</h4>
                                <div>
                                    @adminCan('role.view', 'admin')
                                        <a href="{{ route('admin.role.index') }}" class="btn btn-primary"><i
                                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                                    @endadminCan
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" action="{{ route('admin.role.assign.update') }}" method="POST">
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label for="user">{{ __('Select Admin') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="user_id" id="user"
                                                    class="form-control select2 @error('user_id') is-invalid @enderror">
                                                    <option value="">{{ __('Select Admin') }}</option>
                                                    @foreach ($admins as $admin)
                                                        <option value="{{ $admin->id }}">{{ $admin->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="role">{{ __('Role') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="role[]" id="role"
                                                    class="form-control select2 @error('role') is-invalid @enderror"
                                                    multiple>
                                                    <option value="" disabled>{{ __('Select Role') }}</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-8 offset-md-2">
                                            <x-admin.update-button :text="__('Update')">
                                            </x-admin.update-button>
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
    <script>
        "use strict"
        $('#user').on('change', function(e) {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    url: "{{ url('/admin/role/assign') }}" + "/" + id,
                    beforeSend: function() {
                        $('#update-btn').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#role').empty();
                            $('#role').append(response.data);
                        }
                        $('#update-btn').prop('disabled', false);
                    },
                    error: function(err) {
                        $('#update-btn').prop('disabled', false);
                        toastr.error("{{ __('Failed!') }}")
                        console.log(err);
                    },
                })
            }
        });
    </script>
@endpush
