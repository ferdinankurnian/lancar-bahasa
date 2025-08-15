@php
    $header_admin = Auth::guard('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="" type="image/x-icon">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mode" content="{{ env('PROJECT_MODE') ?? 'LIVE' }}">
    <!-- Custom Meta -->
    @yield('custom_meta')

    @yield('title')
    <link rel="icon" href="{{ asset($setting->favicon) }}">
    @include('admin.partials.styles')
    @stack('css')
    @yield('vite')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="mr-2 form-inline">
                    <ul class="mr-3 navbar-nav d-flex align-items-center">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-none"><i
                                    class="fas fa-search"></i></a></li>
                        @if (Module::isEnabled('Language') && Route::has('set-language'))
                            @if (count(allLanguages()?->where('status', 1)) > 1)
                                <form id="setLanguageHeader" action="{{ route('set-language') }}">
                                    <select class="bg-transparent form-control-sm border-light select_js"
                                        name="code">
                                        @forelse (allLanguages()?->where('status', 1) as $language)
                                            <option class="text-dark" value="{{ $language->code }}"
                                                {{ getSessionLanguage() == $language->code ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @empty
                                            <option value="en" {{ getSessionLanguage() == 'en' ? 'selected' : '' }}>
                                                English
                                            </option>
                                        @endforelse
                                    </select>
                                </form>
                            @endif
                        @endif

                        @if (count(allCurrencies()?->where('status', 'active')) > 1)
                            <form action="{{ route('set-currency') }}" class="set-currency-header">
                                <select name="currency"
                                    class="change-currency bg-transparent form-control-sm border-light ml-2 select_js">
                                    @forelse (allCurrencies()?->where('status', 'active') as $currency)
                                        <option class="text-dark" value="{{ $currency->currency_code }}"
                                            {{ getSessionCurrency() == $currency->currency_code ? 'selected' : '' }}>
                                            {{ $currency->currency_name }}
                                        </option>
                                    @empty
                                        <option value="USD" {{ getSessionCurrency() == 'USD' ? 'selected' : '' }}>
                                            {{ __('USD') }}
                                        </option>
                                    @endforelse
                                </select>
                            </form>
                        @endif
                    </ul>
                </div>
                <div class="mr-auto search-box position-relative">
                    <input type="text" id="search_menu" class="form-control"
                        placeholder="{{ __('Search options') }}">
                    <div id="admin_menu_list" class="position-absolute d-none rounded-2">
                        @foreach (adminSearchRouteList() as $route_item)
                            @if (checkAdminHasPermission($route_item?->permission) || empty($route_item?->permission))
                                <a @isset($route_item->tab) 
                                        data-active-tab="{{ $route_item->tab }}" class="border-bottom search-menu-item" 
                                    @else 
                                        class="border-bottom" 
                                    @endisset
                                    href="{{ $route_item?->route }}">{{ $route_item?->name }}</a>
                            @endif
                        @endforeach
                        <a class="not-found-message d-none" href="javascript:;">{{ __('Not Found!') }}</a>
                    </div>
                </div>

                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle">
                        <a target="_blank" href="{{ route('home') }}" class="nav-link nav-link-lg">
                            <i class="fas fa-home"></i> {{ __('Visit Website') }}</i>
                        </a>
                    </li>

                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            @if ($header_admin->image)
                                <img alt="image" src="{{ asset($header_admin->image) }}"
                                    class="mr-1 rounded-circle">
                            @else
                                <img alt="image" src="" class="mr-1 rounded-circle">
                            @endif

                            <div class="d-sm-none d-lg-inline-block">{{ $header_admin->name }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('admin.settings') }}" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> {{ __('Settings') }}
                            </a>


                            @adminCan('admin.profile.view')
                                <a href="{{ route('admin.edit-profile') }}" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> {{ __('Profile') }}
                                </a>
                            @endadminCan
                            <a href="javascript:;" class="dropdown-item has-icon d-flex align-items-center text-danger"
                                onclick="event.preventDefault(); $('#admin-logout-form').trigger('submit');">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>
                        </div>
                    </li>

                </ul>
            </nav>

            @if (request()->routeIs(
                    'admin.general-setting',
                    'admin.marketing-setting',
                    'admin.commission-setting',
                    'admin.crediential-setting',
                    'admin.email-configuration',
                    'admin.edit-email-template',
                    'admin.currency.*',
                    'admin.seo-setting',
                    'admin.custom-code',
                    'admin.cache-clear',
                    'admin.database-clear',
                    'admin.system-update.index',
                    'admin.admin.*',
                    'admin.languages.*',
                    'admin.basicpayment',
                    'admin.paymentgateway',
                    'admin.role.*'))
                @include('admin.settings.sidebar')
            @else
                @include('admin.sidebar')
            @endif
            @yield('admin-content')

            <footer class="main-footer">
                <div class="footer-left">
                    {{ $setting->copyright_text }}
                </div>
                <div class="footer-right">
                    <span>{{ __('version') }}: {{ $setting->version ?? '' }}</span>
                </div>
            </footer>

        </div>
    </div>

    {{-- start admin logout form --}}
    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    {{-- end admin logout form --}}
    @include('admin.partials.modal')
    @include('admin.partials.javascripts')
    @include('global.dynamic-js-variables')

    @stack('js')

</body>

</html>
