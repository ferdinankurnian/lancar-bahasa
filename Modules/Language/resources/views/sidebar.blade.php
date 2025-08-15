@if (Module::isEnabled('Language') && Route::has('admin.languages.index'))
<li class="{{ Route::is('admin.languages.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.languages.index') }}">
        <i class="fas fa-language"></i> <span>{{ __('Manage Language') }}</span>
    </a>
</li>
@endif
