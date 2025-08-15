<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}"><img class="admin_logo" src="{{ asset($setting->logo) ?? '' }}"
                    alt="{{ $setting->app_name ?? '' }}"></a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset($setting->favicon) ?? '' }}"
                    alt="{{ $setting->app_name ?? '' }}"></a>
        </div>

        <ul class="sidebar-menu">
            @adminCan('dashboard.view')
                <li class="{{ isRoute('admin.dashboard', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endadminCan

            @if(checkAdminHasPermission('course.management') || checkAdminHasPermission('course.certificate.management') || checkAdminHasPermission('badge.management') || checkAdminHasPermission('blog.view'))
                <li class="menu-header">{{ __('Manage Contents') }}</li>

                @if (Module::isEnabled('Course') && checkAdminHasPermission('course.management'))
                    @include('course::sidebar')
                @endif

                @if (Module::isEnabled('CertificateBuilder') && checkAdminHasPermission('course.certificate.management'))
                    @include('certificatebuilder::sidebar')
                @endif

                @if (Module::isEnabled('Badges') && checkAdminHasPermission('badge.management'))
                    @include('badges::sidebar')
                @endif

                @if (Module::isEnabled('Blog'))
                    @include('blog::sidebar')
                @endif
            @endif

            @if(checkAdminHasPermission('order.management') || checkAdminHasPermission('coupon.management') || checkAdminHasPermission('withdraw.management'))
                <li class="menu-header">{{ __('Manage Orders') }}</li>

                @if (Module::isEnabled('Order') && checkAdminHasPermission('order.management'))
                    @include('order::sidebar')
                @endif

                @if (Module::isEnabled('Coupon') && checkAdminHasPermission('coupon.management'))
                    @include('coupon::sidebar')
                @endif

                @if (Module::isEnabled('PaymentWithdraw') && checkAdminHasPermission('withdraw.management'))
                    @include('paymentwithdraw::admin.sidebar')
                @endif
            @endif

            @if(checkAdminHasPermission('instructor.request.list') || checkAdminHasPermission('customer.view') || checkAdminHasPermission('location.view'))
                <li class="menu-header">{{ __('Manage Users') }}</li>
                @if (
                    (Module::isEnabled('InstructorRequest') && checkAdminHasPermission('instructor.request.list')) ||
                        checkAdminHasPermission('instructor.request.setting'))
                    @include('instructorrequest::sidebar')
                @endif

                @if (Module::isEnabled('Customer') && checkAdminHasPermission('customer.view'))
                    @include('customer::sidebar')
                @endif

                @if (Module::isEnabled('Location') && checkAdminHasPermission('location.view'))
                    @include('location::sidebar')
                @endif
            @endif

            @if(checkAdminHasPermission('appearance.management') || checkAdminHasPermission('section.management') || checkAdminHasPermission('footer.management') || checkAdminHasPermission('brand.managemen'))
                <li class="menu-header">{{ __('Site Contents') }}</li>
                @if (Module::isEnabled('SiteAppearance') && checkAdminHasPermission('appearance.management'))
                    @include('siteappearance::sidebar')
                @endif

                @if (Module::isEnabled('Frontend') && checkAdminHasPermission('section.management'))
                    @include('frontend::sidebar')
                @endif

                @if (Module::isEnabled('Brand') && checkAdminHasPermission('brand.management'))
                    @include('brand::sidebar')
                @endif

                @if (Module::isEnabled('FooterSetting') && checkAdminHasPermission('footer.management'))
                    @include('footersetting::sidebar')
                @endif
            @endif


            @if(checkAdminHasPermission('menu.view') || checkAdminHasPermission('page.management') || checkAdminHasPermission('social.link.management') || checkAdminHasPermission('faq.view'))
                <li class="menu-header">{{ __('Manage Website') }}</li>

                @if (Module::isEnabled('MenuBuilder') && checkAdminHasPermission('menu.view'))
                    @include('menubuilder::sidebar')
                @endif
                
                @if (Module::isEnabled('PageBuilder') && checkAdminHasPermission('page.management'))
                    @include('pagebuilder::sidebar')
                @endif

                @if (Module::isEnabled('SocialLink') && checkAdminHasPermission('social.link.management'))
                    @include('sociallink::sidebar')
                @endif

                @if (Module::isEnabled('Faq') && checkAdminHasPermission('faq.view'))
                    @include('faq::sidebar')
                @endif
            @endif

            @if(checkAdminHasPermission('setting.view') || checkAdminHasPermission('basic.payment.view') || checkAdminHasPermission('payment.view') || checkAdminHasPermission('currency.view') || checkAdminHasPermission('role.view') || checkAdminHasPermission('admin.view'))
                <li class="menu-header">{{ __('Settings') }}</li>
                <li class="{{ isRoute('admin.settings', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                </li>
            @endif

            @if(checkAdminHasPermission('newsletter.view') || checkAdminHasPermission('testimonial.view') || checkAdminHasPermission('contect.message.view'))
                <li class="menu-header">{{ __('Utility') }}</li>

                @if (Module::isEnabled('NewsLetter') && checkAdminHasPermission('newsletter.view'))
                    @include('newsletter::sidebar')
                @endif

                @if (Module::isEnabled('Testimonial') && checkAdminHasPermission('testimonial.view'))
                    @include('testimonial::sidebar')
                @endif

                @if (Module::isEnabled('ContactMessage') && checkAdminHasPermission('contect.message.view'))
                    @include('contactmessage::sidebar')
                @endif
            @endif
        </ul>
    </aside>
</div>
