@php
    $nav_menu = Cache::rememberForever('nav_menu', function () {
        return menuGetBySlug('nav-menu');
    });
    $categories = \Modules\Course\app\Models\CourseCategory::with('translation')
        ->where('status', 1)
        ->whereNull('parent_id')
        ->get();
@endphp
<!-- header-area -->
<header>
    @if ($setting?->header_topbar_status == 'active')
        <div class="tg-header__top">
            <div class="container custom-container xl_container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tg-header__top-info list-wrap">
                            @if ($setting?->site_address)
                                <li><img src="{{ asset('frontend/img/icons/map_marker.svg') }}" alt="Icon">
                                    <span>{{ $setting?->site_address }}</span>
                                </li>
                            @endif
                            @if ($setting?->site_email)
                                <li><img src="{{ asset('frontend/img/icons/envelope.svg') }}" alt="Icon"> <a
                                        href="mailto:{{ $setting?->site_email }}">{{ $setting?->site_email }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tg-header__top-right">
                            @if ($setting?->header_social_status == 'active')
                                <ul class="tg-header__top-social list-wrap">
                                    <li>{{ __('Follow Us On') }} :</li>
                                    @foreach (getSocialLinks() as $socialLink)
                                        <li class="header-social">
                                            <a href="{{ $socialLink->link }}" target="_blank">
                                                <img src="{{ asset($socialLink->icon) }}" alt="img">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="header_language_area d-flex flex-wrap d-none d-xl-flex">

                                <ul>
                                    @if (count(allLanguages()?->where('status', 1)) > 1)
                                        <form action="{{ route('set-language') }}" id="setLanguageHeader">
                                            <select name="code" class="select_js">
                                                @forelse (allLanguages()?->where('status', 1) as $language)
                                                    <option value="{{ $language->code }}"
                                                        {{ getSessionLanguage() == $language->code ? 'selected' : '' }}>
                                                        {{ $language->name }}
                                                    </option>
                                                @empty
                                                    <option value="en"
                                                        {{ getSessionLanguage() == 'en' ? 'selected' : '' }}>
                                                        {{ __('English') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </form>
                                    @endif
                                    @if (count(allCurrencies()?->where('status', 'active')) > 1)
                                        <form action="{{ route('set-currency') }}" class="set-currency-header"
                                            method="GET">
                                            <select name="currency" class="change-currency select_js">
                                                @forelse (allCurrencies()?->where('status', 'active') as $currency)
                                                    <option value="{{ $currency->currency_code }}"
                                                        {{ getSessionCurrency() == $currency->currency_code ? 'selected' : '' }}>
                                                        {{ $currency->currency_name }}
                                                    </option>
                                                @empty
                                                    <option value="USD"
                                                        {{ getSessionCurrency() == 'USD' ? 'selected' : '' }}>
                                                        {{ __('USD') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </form>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="header-fixed-height"></div>
    <div id="sticky-header" class="tg-header__area">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="tgmenu__wrap">
                        <nav class="tgmenu__nav">
                            <div class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset($setting?->logo) }}"
                                        alt="Logo"></a>
                            </div>
                            <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-xl-flex">
                                @if ($nav_menu)
                                    <ul class="navigation">
                                        @foreach ($nav_menu as $menu)
                                            @if ($menu['link'] == '/' && $setting?->show_all_homepage == 1)
                                                <li class="menu-item-has-children">
                                                    <a href="{{ url('/') }}"
                                                        title="">{{ __('Home') }}</a>
                                                    <ul class="sub-menu">
                                                        @foreach (App\Enums\ThemeList::cases() as $theme)
                                                            <li class=""><a href="{{ route('change-theme', $theme->value) }}" title="">{{ __($theme->value) }}</a></li>
                                                        @endforeach
                                                    </ul><!-- /.sub-menu -->
                                                </li>
                                            @else
                                                <li class="{{ $menu['child'] ? 'menu-item-has-children' : '' }}">
                                                    <a href="{{ $menu['child'] ? 'javascript:;' : url($menu['link']) }}"
                                                        title="">{{ $menu['label'] }}</a>
                                                    @if ($menu['child'])
                                                        <ul class="sub-menu">
                                                            @foreach ($menu['child'] as $child)
                                                                <li class=""><a href="{{ url($child['link']) }}"
                                                                        title="">{{ $child['label'] }}</a></li>
                                                            @endforeach
                                                        </ul><!-- /.sub-menu -->
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul><!-- /.menu -->
                                @endif

                            </div>
                            <div class="tgmenu__search d-none d-md-block">
                                <form action="{{ route('courses') }}" class="tgmenu__search-form">
                                    <div class="select-grp">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.992 13.25C10.5778 13.25 10.242 13.5858 10.242 14C10.242 14.4142 10.5778 14.75 10.992 14.75V13.25ZM16.992 14.75C17.4062 14.75 17.742 14.4142 17.742 14C17.742 13.5858 17.4062 13.25 16.992 13.25V14.75ZM14.742 11C14.742 10.5858 14.4062 10.25 13.992 10.25C13.5778 10.25 13.242 10.5858 13.242 11H14.742ZM13.242 17C13.242 17.4142 13.5778 17.75 13.992 17.75C14.4062 17.75 14.742 17.4142 14.742 17H13.242ZM1 6.4H1.75H1ZM1 1.6H1.75H1ZM6.4 1V1.75V1ZM7 1.6H6.25H7ZM6.4 7V6.25V7ZM1 16.4H1.75H1ZM1 11.6H1.75H1ZM6.4 11V11.75V11ZM7 11.6H6.25H7ZM6.4 17V17.75V17ZM1.6 17V17.75V17ZM11 6.4H11.75H11ZM11 1.6H11.75H11ZM11.6 1V0.25V1ZM16.4 1V1.75V1ZM17 1.6H17.75H17ZM17 6.4H17.75H17ZM16.4 7V6.25V7ZM10.992 14.75H13.992V13.25H10.992V14.75ZM16.992 13.25H13.992V14.75H16.992V13.25ZM14.742 14V11H13.242V14H14.742ZM13.242 14V17H14.742V14H13.242ZM1.75 6.4V1.6H0.25V6.4H1.75ZM1.75 1.6C1.75 1.63978 1.7342 1.67794 1.70607 1.70607L0.645406 0.645406C0.392232 0.89858 0.25 1.24196 0.25 1.6H1.75ZM1.70607 1.70607C1.67794 1.7342 1.63978 1.75 1.6 1.75V0.25C1.24196 0.25 0.89858 0.392232 0.645406 0.645406L1.70607 1.70607ZM1.6 1.75H6.4V0.25H1.6V1.75ZM6.4 1.75C6.36022 1.75 6.32207 1.7342 6.29393 1.70607L7.35459 0.645406C7.10142 0.392231 6.75804 0.25 6.4 0.25V1.75ZM6.29393 1.70607C6.2658 1.67793 6.25 1.63978 6.25 1.6H7.75C7.75 1.24196 7.60777 0.898581 7.35459 0.645406L6.29393 1.70607ZM6.25 1.6V6.4H7.75V1.6H6.25ZM6.25 6.4C6.25 6.36022 6.2658 6.32207 6.29393 6.29393L7.35459 7.35459C7.60777 7.10142 7.75 6.75804 7.75 6.4H6.25ZM6.29393 6.29393C6.32207 6.2658 6.36022 6.25 6.4 6.25V7.75C6.75804 7.75 7.10142 7.60777 7.35459 7.35459L6.29393 6.29393ZM6.4 6.25H1.6V7.75H6.4V6.25ZM1.6 6.25C1.63978 6.25 1.67793 6.2658 1.70607 6.29393L0.645406 7.35459C0.898581 7.60777 1.24196 7.75 1.6 7.75V6.25ZM1.70607 6.29393C1.7342 6.32207 1.75 6.36022 1.75 6.4H0.25C0.25 6.75804 0.392231 7.10142 0.645406 7.35459L1.70607 6.29393ZM1.75 16.4V11.6H0.25V16.4H1.75ZM1.75 11.6C1.75 11.6398 1.7342 11.6779 1.70607 11.7061L0.645406 10.6454C0.392231 10.8986 0.25 11.242 0.25 11.6H1.75ZM1.70607 11.7061C1.67793 11.7342 1.63978 11.75 1.6 11.75V10.25C1.24196 10.25 0.898581 10.3922 0.645406 10.6454L1.70607 11.7061ZM1.6 11.75H6.4V10.25H1.6V11.75ZM6.4 11.75C6.36022 11.75 6.32207 11.7342 6.29393 11.7061L7.35459 10.6454C7.10142 10.3922 6.75804 10.25 6.4 10.25V11.75ZM6.29393 11.7061C6.2658 11.6779 6.25 11.6398 6.25 11.6H7.75C7.75 11.242 7.60777 10.8986 7.35459 10.6454L6.29393 11.7061ZM6.25 11.6V16.4H7.75V11.6H6.25ZM6.25 16.4C6.25 16.3602 6.2658 16.3221 6.29393 16.2939L7.35459 17.3546C7.60777 17.1014 7.75 16.758 7.75 16.4H6.25ZM6.29393 16.2939C6.32207 16.2658 6.36022 16.25 6.4 16.25V17.75C6.75804 17.75 7.10142 17.6078 7.35459 17.3546L6.29393 16.2939ZM6.4 16.25H1.6V17.75H6.4V16.25ZM1.6 16.25C1.63978 16.25 1.67793 16.2658 1.70607 16.2939L0.645406 17.3546C0.898581 17.6078 1.24196 17.75 1.6 17.75V16.25ZM1.70607 16.2939C1.7342 16.3221 1.75 16.3602 1.75 16.4H0.25C0.25 16.758 0.392231 17.1014 0.645406 17.3546L1.70607 16.2939ZM11.75 6.4V1.6H10.25V6.4H11.75ZM11.75 1.6C11.75 1.63978 11.7342 1.67793 11.7061 1.70607L10.6454 0.645406C10.3922 0.898581 10.25 1.24196 10.25 1.6H11.75ZM11.7061 1.70607C11.6779 1.7342 11.6398 1.75 11.6 1.75V0.25C11.242 0.25 10.8986 0.392231 10.6454 0.645406L11.7061 1.70607ZM11.6 1.75H16.4V0.25H11.6V1.75ZM16.4 1.75C16.3602 1.75 16.3221 1.7342 16.2939 1.70607L17.3546 0.645406C17.1014 0.392231 16.758 0.25 16.4 0.25V1.75ZM16.2939 1.70607C16.2658 1.67793 16.25 1.63978 16.25 1.6H17.75C17.75 1.24196 17.6078 0.898581 17.3546 0.645406L16.2939 1.70607ZM16.25 1.6V6.4H17.75V1.6H16.25ZM16.25 6.4C16.25 6.36022 16.2658 6.32207 16.2939 6.29393L17.3546 7.35459C17.6078 7.10142 17.75 6.75804 17.75 6.4H16.25ZM16.2939 6.29393C16.3221 6.2658 16.3602 6.25 16.4 6.25V7.75C16.758 7.75 17.1014 7.60777 17.3546 7.35459L16.2939 6.29393ZM16.4 6.25H11.6V7.75H16.4V6.25ZM11.6 6.25C11.6398 6.25 11.6779 6.2658 11.7061 6.29393L10.6454 7.35459C10.8986 7.60777 11.242 7.75 11.6 7.75V6.25ZM11.7061 6.29393C11.7342 6.32207 11.75 6.36022 11.75 6.4H10.25C10.25 6.75804 10.3922 7.10142 10.6454 7.35459L11.7061 6.29393Z"
                                                fill="currentcolor" />
                                        </svg>

                                        <select class="form-select select_js w_150px"
                                            aria-label="Default select example" name="main_category">
                                            <option selected disabled>{{ __('Categories') }}</option>
                                            @foreach ($categories as $category)
                                                <option @selected(request('main_category') == $category->slug) value="{{ $category->slug }}">
                                                    {{ $category?->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <input type="text" placeholder="{{ __('Search For Course') }} . . ."
                                            name="search" value="{{ request('search') }}">
                                        <button type="submit"><i class="flaticon-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="tgmenu__action">
                                <ul class="list-wrap">
                                    <li class="mini-cart-icon">
                                        <a href="{{ route('cart') }}" class="cart-count">
                                            <img src="{{ asset('frontend/img/icons/cart.svg') }}" class="injectable"
                                                alt="img">
                                            <span class="mini-cart-count">{{ Cart::content()->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="mini-cart-icon user_icon">
                                        <a href="javascript:;" class="cart-count">
                                            <img src="{{ asset('frontend/img/icons/menu_user.svg') }}"
                                                alt="img">
                                        </a>
                                        <ul class="menu_user_list">
                                            @auth('admin')
                                                <li><a href="{{ route('admin.dashboard') }}">{{ __('Admin Dashboard') }}</a>
                                                </li>
                                            @endauth
                                            @guest
                                                <li><a href="{{ route('login') }}">{{ __('Sign in') }}</a></li>
                                                <li><a href="{{ route('register') }}">{{ __('Sign Up') }}</a></li>
                                            @else
                                                @if (Auth::guard('web')->user())
                                                    @if (instructorStatus() == 'approved')
                                                        <li><a
                                                                href="{{ route('instructor.dashboard') }}">{{ __('Instructor Dashboard') }}</a>
                                                        </li>
                                                    @endif
                                                    <li><a
                                                            href="{{ route('student.dashboard') }}">{{ __('Student Dashboard') }}</a>
                                                    </li>
                                                    <li><a
                                                            href="{{ userAuth()->role == 'instructor' ? route('instructor.setting.index') : route('student.setting.index') }}">{{ __('Profile') }}</a>
                                                    </li>
                                                    <li><a
                                                            href="{{ userAuth()->role == 'instructor' ? route('instructor.courses.index') : route('student.enrolled-courses') }}">{{ __('Courses') }}</a>
                                                    </li>
                                                    <li><a href=""
                                                            class="text-danger logout-btn">{{ __('Logout') }}</a>
                                                    </li>
                                                @endif
                                            @endguest
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="mobile-nav-toggler"><i class="tg-flaticon-menu-1"></i></div>
                        </nav>
                    </div>

                    <!-- Mobile Menu  -->
                    <div class="tgmobile__menu">
                        <nav class="tgmobile__menu-box">
                            <div class="close-btn"><i class="tg-flaticon-close-1"></i></div>
                            <div class="nav-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset(Cache::get('setting')->logo) }}"
                                        alt="Logo"></a>
                            </div>

                            <div class="header_language_area d-flex flex-wrap">

                                <ul>
                                    @if (count(allLanguages()?->where('status', 1)) > 1)
                                        <form action="{{ route('set-language') }}"
                                            class="change-language-header-mobile" method="GET">
                                            <select name="code" class="select_js set-language-header-mobile">
                                                @forelse (allLanguages()?->where('status', 1) as $language)
                                                    <option value="{{ $language->code }}"
                                                        {{ getSessionLanguage() == $language->code ? 'selected' : '' }}>
                                                        {{ $language->name }}
                                                    </option>
                                                @empty
                                                    <option value="en"
                                                        {{ getSessionLanguage() == 'en' ? 'selected' : '' }}>
                                                        {{ __('English') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </form>
                                    @endif
                                    @if (count(allCurrencies()?->where('status', 'active')) > 1)
                                        <form action="{{ route('set-currency') }}"
                                            class="change-currency-header-mobile" method="GET">
                                            <select name="currency" class="set-currency-header-mobile select_js">
                                                @forelse (allCurrencies()?->where('status', 'active') as $currency)
                                                    <option value="{{ $currency->currency_code }}"
                                                        {{ getSessionCurrency() == $currency->currency_code ? 'selected' : '' }}>
                                                        {{ $currency->currency_name }}
                                                    </option>
                                                @empty
                                                    <option value="USD"
                                                        {{ getSessionCurrency() == 'USD' ? 'selected' : '' }}>
                                                        {{ __('USD') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </form>
                                    @endif
                                </ul>
                            </div>
                            <ul class="mobile_menu_login d-flex flex-wrap">
                                @auth('admin')
                                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Admin Dashboard') }}</a></li>
                                @endauth
                                @guest
                                    <li><a href="{{ route('login') }}">{{ __('login') }}</a></li>
                                    <li><a href="{{ route('register') }}">{{ __('register') }}</a></li>
                                @endguest

                                @auth('web')
                                    @php
                                        $user = Auth::guard('web')->user();
                                        $dashboardRoute =
                                            $user->role == 'instructor' ? 'instructor.dashboard' : 'student.dashboard';
                                        $coursesRoute =
                                            $user->role == 'instructor'
                                                ? 'instructor.courses.index'
                                                : 'student.enrolled-courses';
                                    @endphp
                                    <li><a href="{{ route($dashboardRoute) }}">{{ __('Dashboard') }}</a></li>
                                    <li><a href="{{ route($coursesRoute) }}">{{ __('Courses') }}</a></li>
                                @endauth
                            </ul>

                            <div class="tgmobile__search">
                                <form action="{{ route('courses') }}">
                                    <select class="form-select w_150px" aria-label="Default select example"
                                        name="main_category">
                                        <option selected disabled>{{ __('Categories') }}</option>
                                        @foreach ($categories as $category)
                                            <option @selected(request('main_category') == $category->slug) value="{{ $category->slug }}">
                                                {{ $category?->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" placeholder="{{ __('Search here') }}..." name="search">
                                    <button><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                            <div class="tgmobile__menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="social-links">
                                @if (count(getSocialLinks()) > 0)
                                    <ul class="list-wrap">
                                        @foreach (getSocialLinks() as $socialLink)
                                            <li>
                                                <a href="{{ $socialLink->link }}" target="_blank">
                                                    <img src="{{ asset($socialLink->icon) }}" alt="img">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </nav>
                    </div>
                    <div class="tgmobile__menu-backdrop"></div>
                    <!-- End Mobile Menu -->

                    {{-- start admin logout form --}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    {{-- end admin logout form --}}
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-area-end -->
