@if (Module::isEnabled('Location'))
    <li
        class="nav-item dropdown {{ isRoute(['admin.country.*', 'admin.state.*', 'admin.city.*'], 'active') }}">
        <a href="javascript:void()" class="nav-link has-dropdown"><i class="fas fa-location-arrow"></i><span>{{ __('Locations') }}</span></a>

        <ul class="dropdown-menu">
            <li class="{{ isRoute('admin.country.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.country.index') }}">
                    {{ __('Countries') }}
                </a>
            </li>
        </ul>
    </li>
@endif
