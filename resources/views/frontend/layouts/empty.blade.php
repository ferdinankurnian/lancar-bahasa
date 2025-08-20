<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', 'Checkout')</title>
    @include('frontend.layouts.styles') {{-- Include global styles, including toastr.css --}}
</head>
<body>
    @yield('contents')

    {{-- Essential scripts, like jQuery, should be pushed here --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('frontend.layouts.scripts') {{-- Include global scripts, including toastr.js --}}
    @stack('scripts')
</body>
</html>