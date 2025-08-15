@extends('installer::app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>Setup Admin Account</p>
            <div>
                <a class="btn btn-outline-primary @if (!session()->has('step-4-complete')) disabled @endif" href="{{route('setup.configuration')}}">Next &raquo;</a>
            </div>
        </div>
        <div class="card-body">
            <form id="account_form" autocomplete="off">
                <div class="mb-3">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$admin?->name) }}"
                        placeholder="Enter Your Full Name">
                </div>
                <div class="mb-3">
                    <label>E-Mail <span class="text-danger">*</span></label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email',$admin?->email) }}"
                        placeholder="Enter Your E-Mail Address">
                </div>
                <div class="mb-3">
                    <label>Password <span class="text-danger">*</span></label>
                    <input autocomplete="new-password" id="password" type="password" name="password"
                        value="{{ old('password') }}" class="form-control" placeholder="Enter Your Password">
                </div>
                <div class="mb-3">
                    <label>Re-Type Password <span class="text-danger">*</span></label>
                    <input autocomplete="new-password" id="confirm_password" type="password" name="confirm_password"
                        value="{{ old('password') }}" class="form-control" placeholder="Confirm Your Password">
                </div>
                <button type="submit" id="submit_btn" class="btn btn-primary">Create Account</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <p>For script support, contact us at <a href="https://websolutionus.com/page/support"
                target="_blank" rel="noopener noreferrer">@websolutionus</a>. We're here to help. Thank you!</p>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#account_form', async function(e) {
                e.preventDefault();
                let submit_btn, name, email, password, confirm_password;
                submit_btn = $('#submit_btn');
                name = $('#name').val();
                email = $('#email').val();
                password = $('#password').val();
                confirm_password = $('#confirm_password').val();

                if ($.trim(name) === '') {
                    toastr.warning("Name is required");
                } else if ($.trim(email) === '') {
                    toastr.warning("Email is required");
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    toastr.warning('Invalid email format');
                } else if ($.trim(password) === '') {
                    toastr.warning("Password is required");
                } else if ($.trim(password) !== $.trim(confirm_password)) {
                    toastr.warning("Password & Confirm Password Must be same");
                } else {
                    submit_btn.html(
                        'Creating... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).prop('disabled', true);
                    try {
                        let data = {
                            name: name,
                            email: email,
                            password: password,
                            confirm_password: confirm_password,
                        };
                        const res = await makeAjaxRequest(data, "{{ route('setup.account.submit') }}");
                        if (res.success) {
                            toastr.success(res.message);
                            submit_btn.addClass('btn-success').html('Redirecting...');
                            window.location.href = "{{ route('setup.configuration') }}";
                        } else {
                            submit_btn.html('Account Create').prop('disabled', false);
                            toastr.error(res.message);
                        }
                    } catch (error) {
                        submit_btn.html('Account Create').prop('disabled', false);
                        $.each(error.errors, function(index, value) {
                            toastr.error(value);
                        });
                    }
                }
            });
        });
    </script>
@endpush