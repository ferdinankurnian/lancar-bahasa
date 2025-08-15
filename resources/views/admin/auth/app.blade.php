<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="" type="image/x-icon">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    @yield('title')

    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}?v={{$setting?->version}}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap4-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/dev.css') }}?v={{$setting?->version}}">
    @if (session()->has('text_direction') && session()->get('text_direction') !== 'ltr')
        <link rel="stylesheet" href="{{ asset('backend/css/rtl.css') }}?v={{$setting?->version}}">
        <link rel="stylesheet" href="{{ asset('backend/css/dev_rtl.css') }}?v={{$setting?->version}}">
    @endif
    <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/fontawesome-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/clockpicker/dist/bootstrap-clockpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/datetimepicker/jquery.datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/iziToast.min.css') }}">
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    
    <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script src="{{ asset('backend/js/stisla.js') }}"></script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('backend/js/modules-toastr.js') }}"></script>

    <script>
        @if (Session::has('messege'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('messege') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('messege') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('messege') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('messege') }}");
                    break;
            }
        @endif
    </script>
    <!-- Google reCAPTCHA -->
    @if (Cache::get('setting')->recaptcha_status === 'active')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

</body>

</html>
