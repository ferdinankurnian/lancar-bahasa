<li class="menu-header">{{ __('Settings') }}</li>
<li class="{{ Route::is('admin.general-setting') ? 'active' : '' }}"><a class="nav-link"
        href="{{ route('admin.general-setting') }}"><i class="fas fa-cog"></i>
        <span>{{ __('General Settings') }}</span></a></li>

<li class="{{ Route::is('admin.commission-setting') ? 'active' : '' }}"><a class="nav-link"
        href="{{ route('admin.commission-setting') }}"><i class="fas fa-money-bill"></i>
        <span>{{ __('Commission') }}</span></a></li>

<li class="{{ Route::is('admin.crediential-setting') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.crediential-setting') }}"><i class="fas fa-key"></i>
        <span>{{ __('Credential Settings') }}</span>
    </a>
</li>
<li class="{{ Route::is('admin.marketing-setting') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.marketing-setting') }}"><i class="fas fa-ad"></i>
        <span>{{ __('Marketing Settings') }}</span>
    </a>
</li>

<li class="{{ Route::is('admin.email-configuration') || Route::is('admin.edit-email-template') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.email-configuration') }}"><i class="fas fa-envelope"></i>
        <span>{{ __('Email Configuration') }}</span>
    </a>
</li>

@if (Module::isEnabled('Language') && checkAdminHasPermission('language.view'))
    @include('language::sidebar')
@endif

<li class="{{ Route::is('admin.seo-setting') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.seo-setting') }}"><i class="fas fa-search"></i>
        <span>{{ __('SEO Setup') }}</span>
    </a>
</li>
<li class="menu-header">{{ __('Extra Settings') }}</li>
<li class="nav-item dropdown {{ isRoute('admin.custom-code', 'active') }}">
    <a href="javascript:;" class="nav-link has-dropdown">
        <i class="fas fa-code"></i><span>{{ __('Custom Code') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ (request()->routeIs('admin.custom-code') && request('type') == 'css') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('admin.custom-code','css') }}">
                {{ __('CSS') }}
            </a>
        </li>
        <li class="{{ (request()->routeIs('admin.custom-code') && request('type') == 'js') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.custom-code','js') }}">
                {{ __('JS') }}
            </a>
        </li>
    </ul>
</li>

<li class="{{ Route::is('admin.cache-clear') ? 'active' : '' }}"><a class="nav-link"
        href="{{ route('admin.cache-clear') }}"><i class="fas fa-sync"></i>
        <span>{{ __('Clear cache') }}</span>
    </a></li>

<li class="{{ Route::is('admin.database-clear') ? 'active' : '' }}"><a class="nav-link"
        href="{{ route('admin.database-clear') }}"><i class="fas fa-database"></i>
        <span>{{ __('Database Clear') }}</span></a></li>

<li class="{{ Route::is('admin.system-update.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.system-update.index') }}"><i class="fas fa-arrow-circle-up"></i>
        <span>{{ __('System Update') }}</span>
    </a>
</li>
