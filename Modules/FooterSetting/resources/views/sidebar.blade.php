@if (Module::isEnabled('FooterSetting') && Route::has('admin.footersetting.index'))
    <li class="{{ isRoute('admin.footersetting.*', 'active') }}">
        <a class="nav-link" href="{{ route('admin.footersetting.index') }}">
            <i class="fas fa-shoe-prints"></i> <span>{{ __('Footer Setting') }}</span>
        </a>
    </li>
@endif
