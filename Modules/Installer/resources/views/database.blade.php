@extends('installer::app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>Enter Database Details</p>
            <div>
                <a class="btn btn-outline-primary" href="{{ route('setup.requirements') }}">&laquo; Back</a>
            </div>
        </div>
        <form id="database_migrate_form" autocomplete="off">
            <div class="card-body">
                <div class="mb-3">
                    <label>Host <span class="text-danger">*</span></label>
                    <input type="text" name="host" id="host" class="form-control"
                        value="{{ old('host') ?: '127.0.0.1' }}" placeholder="Enter Database Host">
                </div>
                <div class="mb-3">
                    <label>Port <span class="text-danger">*</span></label>
                    <input type="text" name="port" id="port" class="form-control"
                        value="{{ old('port') ?: '3306' }}" placeholder="Enter Database Port. Default Is 3306">
                </div>
                <div class="mb-3">
                    <label>Database Name <span class="text-danger">*</span></label>
                    <input type="text" name="database" id="database" value="{{ old('database') }}" class="form-control"
                        placeholder="Enter Database Name Here">
                    <div class="my-3 d-none" id="reset_database_switcher">
                        <input class="form-check-input" type="checkbox" role="switch" id="reset_database"
                            name="reset_database" {{ old('reset_database') ? 'checked' : '' }}>
                        <label for="reset_database" class="text-danger"><b><small>Database not empty. Are you sure
                                    want to clean this
                                    database?</small></b> </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Database User <span class="text-danger">*</span></label>
                    <input autocomplete="off" type="text" name="user" id="user" value="{{ old('user') }}"
                        class="form-control" placeholder="Enter Database User Here">
                </div>
                <div class="mb-3">
                    <label>Database User Password @if (isset($isLocalHost) && !$isLocalHost)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input autocomplete="new-password" type="password" name="password" id="password"
                        value="{{ old('password') }}" class="form-control" placeholder="Enter Database Password Here">
                </div>
                <div class="mb-3">
                    <b class="text-success">If you prefer a fresh installation without any dummy data, simply toggle the
                        "Fresh Install" switch.</b>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between ">
                <input class="form-check-input" type="checkbox" role="switch" id="fresh_install" name="fresh_install"
                    {{ old('fresh_install') ? 'checked' : '' }}>
                <button type="submit" id="submit_btn" class="btn btn-lg btn-primary">Setup Database</button>
            </div>
        </form>
        <div class="card-footer text-center">
            <p>For script support, contact us at <a href="https://websolutionus.com/page/support"
                target="_blank" rel="noopener noreferrer">@websolutionus</a>. We're here to help. Thank you!</p>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('frontend/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <style>
        .form-switch {
            padding-left: 0px !important;
        }

        .form-check {
            padding-left: 0px !important;
        }

        .toggle.btn.btn-lg {
            width: 212px;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/bootstrap-toggle.jquery.min.js') }}"></script>
    <script>
        "use strict";
        $('#reset_database').bootstrapToggle({
            onlabel: 'Yes',
            offlabel: 'No',
            onstyle: 'danger',
            offstyle: 'secondary',
            size: 'sm'
        });
        $('#fresh_install').bootstrapToggle({
            onlabel: 'Fresh Install',
            offlabel: 'With Dummy Data',
            onstyle: 'success',
            offstyle: 'warning',
            size: 'lg'
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#database_migrate_form', async function(e) {
                e.preventDefault();
                let submit_btn, host, port, database, username, password, fresh_install, reset_database;
                submit_btn = $('#submit_btn');
                host = $('#host').val();
                port = $('#port').val();
                database = $('#database').val();
                username = $('#user').val();
                password = $('#password').val();
                fresh_install = $('#fresh_install');
                reset_database = $('#reset_database');


                if ($.trim(host) === '') {
                    toastr.warning("Host is required");
                } else if ($.trim(port) === '') {
                    toastr.warning("Port is required");
                } else if ($.trim(database) === '') {
                    toastr.warning("Database Name is required");
                } else if ($.trim(username) === '') {
                    toastr.warning("Username is required");
                } else {
                    submit_btn.html(
                        'Migrating... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).prop('disabled', true);
                    try {
                        let data = {
                            host: host,
                            port: port,
                            database: database,
                            user: username,
                            password: password,
                        };
                        if (fresh_install.is(':checked')) {
                            data.fresh_install = fresh_install.val();
                        }
                        if (reset_database.is(':checked')) {
                            data.reset_database = reset_database.val();
                        }
                        const res = await makeAjaxRequest(data,
                            "{{ route('setup.database.submit') }}");
                        $('#reset_database').bootstrapToggle('off');
                        $('#reset_database_switcher').addClass('d-none');
                        if (res.success) {
                            toastr.success(res.message);
                            submit_btn.addClass('btn-success').html('Redirecting...');
                            window.location.href = "{{ route('setup.account') }}";
                        } else if (res.create_database) {
                            toastr.error(res.message);
                            submit_btn.html('Setup Database').prop('disabled', false);
                        } else if (res.reset_database) {
                            $('#reset_database_switcher').removeClass('d-none');
                            toastr.error(res.message);
                            submit_btn.html('Setup Database').prop('disabled', false);
                        } else {
                            submit_btn.html('Setup Database').prop('disabled', false);
                            toastr.error(res.message);
                        }

                    } catch (error) {
                        submit_btn.html('Setup Database').prop('disabled', false);
                        $.each(error.errors, function(index, value) {
                            toastr.error(value);
                        });
                    }
                }
            });
        });
    </script>
@endpush
