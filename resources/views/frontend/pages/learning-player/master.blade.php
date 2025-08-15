<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ __('Learnings') }} | {{ Cache::get('setting')?->app_name }}</title>
    <meta name="description" content="SkillGro - Online Courses & Education Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="course-id" content="{{ @$course->id }}">
    <meta name="lesson-id" content="">
    <meta name="question-id" content="">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(Cache::get('setting')?->favicon) }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/video_player.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/tg-cursor.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}?v={{$setting?->version}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/frontend.css') }}?v={{$setting?->version}}">
    <style>
        :root {
            --tg-theme-primary: {{ $setting->primary_color }};
            --tg-theme-secondary: {{ $setting->secondary_color }};
            --tg-common-color-blue: {{ $setting->common_color_one }};
            --tg-common-color-blue-2: {{ $setting->common_color_two }};
            --tg-common-color-dark: {{ $setting->common_color_three }};
            --tg-common-color-black: {{ $setting->common_color_four }};
            --tg-common-color-dark-2: {{ $setting->common_color_five }};
        }
    </style>
</head>

<body>


    @yield('contents')


    <!-- JS here -->
    <script>
        "use strict";
        var base_url = "{{ url('/') }}";
        var resource_text = "{{ __('Resource') }}";
        var download_des_text = "{{ __('Click on the download button for download the file') }}";
        var download_btn_text = "{{ __('Download') }}";
        var file_type_text = "{{ __('File Type') }}";
        var le_hea = "{{ __('Lesson is started') }}";
        var le_des = "{{ __('This lesson has now started. The lesson will end on') }}";
        var le_fi_he = "{{ __('Lesson is finished') }}";
        var le_fi_des = "{{ __('This lesson is finished. You cant join it.') }}";
        var le_wi_he = "{{ __('Lesson is not started yet') }}";
        var le_wi_des = "{{ __('This lesson will be started on') }}";
        var open_w_txt = "{{ __('Open in Website') }}";
        var cre_mi_txt = "{{ __('credential missing') }}";
        var open_des_txt = "{{ __('Click on the open button for check out the file') }}";
        var open_txt = "{{ __('Open') }}";
        var quiz_st_des_txt = "{{ __('Please go to quiz page for mor information') }}";
        var quiz_st_txt = "{{ __('Start Quiz') }}";
        var no_des_txt = "{{ __('No description') }}";
    </script>
    
    <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/tg-cursor.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('frontend/js/sweetalert.js') }}"></script>

    <script src="{{ asset('frontend/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('frontend/js/video_player.min.js') }}"></script>
    <script src="{{ asset('frontend/js/video_player_youtube.js') }}"></script>
    <script src="{{ asset('frontend/js/videojs-vimeo.js') }}"></script>
    <script>
        "use strict";
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr.options.positionClass = 'toast-bottom-right';
        @session('message')
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.info("{{ $value }}");
                break;
            case 'success':
                toastr.success("{{ $value }}");
                break;
            case 'warning':
                toastr.warning("{{ $value }}");
                break;
            case 'error':
                toastr.error("{{ $value }}");
                break;
        }
        @endsession

        tinymce.init({
            selector: ".text-editor",
            plugins: ["link"],
            toolbar: "bold italic | formats | link",
            toolbar_mode: "floating",
            toolbar_sticky: true,
            menubar: false,
            contextmenu: "link openlink",
        });
    </script>
    <!-- Google reCAPTCHA -->
    @if (Cache::get('setting')->recaptcha_status === 'active')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    @stack('scripts')
</body>

</html>
