@extends('installer::app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>Configure Your Website</p>
            <div>
                <a class="btn btn-outline-primary" href="{{route('setup.account')}}">&laquo; Back</a>
                <a class="btn btn-outline-primary @if (!session()->has('step-5-complete')) disabled @endif" href="{{route('setup.smtp')}}">Next &raquo;</a>
            </div>
        </div>
        <div class="card-body">
            <form id="config_form" autocomplete="off">
                <div class="mb-3">
                    <label>App Name <span class="text-danger">*</span></label>
                    <input type="text" id="config_app_name" name="config_app_name" class="form-control"
                        value="{{ old('config_app_name',$app_name ?? null) }}" placeholder="Enter Your App Name">
                </div>
                <button type="submit" id="submit_btn" class="btn btn-primary">Save Config</button>
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
            $(document).on('submit', '#config_form', async function(e) {
                e.preventDefault();
                let config_app_name = $('#config_app_name').val();
                let submit_btn = $('#submit_btn');

                if ($.trim(config_app_name) === '') {
                    toastr.warning("App Name is required");
                } else {
                    submit_btn.html(
                        'Saving... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    ).prop('disabled', true);
                    try {
                        const res = await makeAjaxRequest({
                                config_app_name: config_app_name
                            },
                            "{{ route('setup.configuration.submit') }}");
                        if (res.success) {
                            toastr.success(res.message);
                            submit_btn.addClass('btn-success').html('Redirecting...');
                            window.location.href = "{{ route('setup.smtp') }}";
                        } else {
                            submit_btn.html('Save Config').prop('disabled', false);
                            toastr.error(res.message);
                        }
                    } catch (error) {
                        submit_btn.html('Save Config').prop('disabled', false);
                        $.each(error.errors, function(index, value) {
                            toastr.error(value);
                        });
                    }
                }
            });
        });
    </script>
@endpush