<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/flaticon-skillgro.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/default-icons.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/odometer.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/plyr.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">
@if ($setting?->cursor_dot_status == 'active')
    <link rel="stylesheet" href="{{ asset('frontend/css/tg-cursor.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/nice-select/nice-select.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}?v={{ $setting?->version }}">
<link rel="stylesheet" href="{{ asset('frontend/css/frontend.css') }}?v={{ $setting?->version }}">

@if (Session::has('text_direction') && Session::get('text_direction') == 'rtl')
    <!-- RTL CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/rtl.css') }}?v={{ $setting?->version }}">
@endif

{{-- Dynamic root colors --}}
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
