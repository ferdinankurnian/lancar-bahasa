<li class="nav-item dropdown {{ isRoute(['admin.site-appearance.*', 'admin.section-setting.*', 'admin.site-color-setting.*'], 'active') }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-swatchbook"></i>
        <span>{{ __('Appearance') }} </span>

    </a>
    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.site-appearance.*', 'active') }}">
            <a class="nav-link" href="{{ route('admin.site-appearance.index') }}">{{ __('Site Themes') }}</a></li>
        <li class="{{ isRoute('admin.section-setting.*', 'active') }}">
            <a class="nav-link" href="{{ route('admin.section-setting.index') }}">{{ __('Section Setting') }}</a></li>
        <li class="{{ isRoute('admin.site-color-setting.*', 'active') }}">
            <a class="nav-link" href="{{ route('admin.site-color-setting.index') }}">{{ __('Site Colors') }}</a></li>
    </ul>
</li>
