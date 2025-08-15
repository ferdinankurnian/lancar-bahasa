@extends('installer::app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>SMTP credentials setup.</p>
            <div>
                <a class="btn btn-outline-primary" href="{{ route('setup.configuration') }}">&laquo; Back</a>
                <a class="btn btn-outline-primary @if (!session()->has('step-6-complete')) disabled @endif" href="{{ route('setup.complete') }}">Next &raquo;</a>
            </div>
        </div>
        <div class="card-body">
            <form id="smtp_form" autocomplete="off">
                <div class="mb-3">
                    <label>Mail Host <span class="text-danger">*</span></label>
                    <input type="text" id="mail_host" name="mail_host" value="{{ $email?->mail_host }}"
                        class="form-control" placeholder="Enter Your SMTP mail host">
                </div>
                <div class="mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" value="{{ $email?->email }}" class="form-control"
                        placeholder="Enter Your SMTP email">
                </div>
                <div class="mb-3">
                    <label>SMTP User Name <span class="text-danger">*</span></label>
                    <input type="text" id="smtp_username" name="smtp_username" value="{{ $email?->smtp_username }}"
                        class="form-control" placeholder="Enter Your SMTP User Name">
                </div>
                <div class="mb-3">
                    <label>SMTP Password <span class="text-danger">*</span></label>
                    <input type="text" id="smtp_password" name="smtp_password" value="{{ $email?->smtp_password }}"
                        class="form-control" placeholder="Enter Your SMTP Password">
                </div>
                <div class="mb-3">
                    <label>Mail Port <span class="text-danger">*</span></label>
                    <input type="text" id="mail_port" name="mail_port" value="{{ $email?->mail_port }}"
                        class="form-control" placeholder="Enter Your SMTP Mail Port">
                </div>
                <div class="mb-3">
                    <label>Mail Sender Name <span class="text-danger">*</span></label>
                    <input type="text" id="mail_sender_name" name="mail_sender_name" value="{{ $email?->mail_sender_name }}"
                        class="form-control" placeholder="Enter Mail Sender Name">
                </div>
                <div class="mb-3">
                    <label>Mail Encryption <span class="text-danger">*</span></label>
                    <select name="mail_encryption" id="mail_encryption" class="form-control form-select">
                        <option {{ $email?->mail_encryption == 'tls' ? 'selected' : '' }} value="tls">TLS</option>
                        <option {{ $email?->mail_encryption == 'ssl' ? 'selected' : '' }} value="ssl">SSL</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between ">
                    <button type="submit" id="submit_btn" class="btn btn-primary">SMTP Setup</button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#skipModal">Skip</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <p>For script support, contact us at <a href="https://websolutionus.com/page/support"
                target="_blank" rel="noopener noreferrer">@websolutionus</a>. We're here to help. Thank you!</p>
        </div>
    </div>
    <!-- Skip Modal -->
    <div class="modal" id="skipModal">
        <div class="modal-dialog">
            <form class="modal-content" action="{{route('setup.smtp.skip')}}" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Skip SMTP Setup</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center text-danger">Are you sure you want to skip the SMTP setup? Skipping this step will prevent users from sending any
                        emails or receiving verification emails.</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Yes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#smtp_form', async function(e) {
                e.preventDefault();
                let mail_host = $('#mail_host').val();
                let email = $('#email').val();
                let smtp_username = $('#smtp_username').val();
                let smtp_password = $('#smtp_password').val();
                let mail_port = $('#mail_port').val();
                let mail_encryption = $('#mail_encryption').val();
                let mail_sender_name = $('#mail_sender_name').val();
                let submit_btn = $('#submit_btn');

                if ($.trim(mail_host) === '') {
                    toastr.warning("Mail host is required");
                } else if ($.trim(email) === '') {
                    toastr.warning("Email is required");
                } else if ($.trim(smtp_username) === '') {
                    toastr.warning("Smtp username is required");
                } else if ($.trim(smtp_password) === '') {
                    toastr.warning("Smtp password is required");
                } else if ($.trim(mail_port) === '') {
                    toastr.warning("Mail port is required");
                } else if ($.trim(mail_encryption) === '') {
                    toastr.warning("Mail encryption is required");
                }else if ($.trim(mail_sender_name) === '') {
                    toastr.warning("Mail Sender Name is required");
                } else {
                    submit_btn.html(
                        'Saving... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).prop('disabled', true);
                    try {
                        const res = await makeAjaxRequest({
                                mail_host: mail_host,
                                email: email,
                                smtp_username: smtp_username,
                                smtp_password: smtp_password,
                                mail_port: mail_port,
                                mail_encryption: mail_encryption,
                                mail_sender_name: mail_sender_name,
                            },
                            "{{ route('setup.smtp.update') }}");
                        if (res.success) {
                            toastr.success(res.message);
                            submit_btn.addClass('btn-success').html('Redirecting...');
                            window.location.href = "{{ route('setup.complete') }}";
                        } else {
                            submit_btn.html('SMTP Setup').prop('disabled', false);
                            toastr.error(res.message);
                        }
                    } catch (error) {
                        submit_btn.html('SMTP Config').prop('disabled', false);
                        $.each(error.errors, function(index, value) {
                            toastr.error(value);
                        });
                    }
                }
            });
        });
    </script>
@endpush