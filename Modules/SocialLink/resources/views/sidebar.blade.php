@if (Module::isEnabled('SocialLink') && Route::has('admin.social-link.index'))
    <li class="{{ isRoute('admin.social-link.*', 'active') }}">
        <a class="nav-link" href="{{ route('admin.social-link.index') }}">
            <i class="fas fa-hashtag"></i> <span>{{ __('Social Links') }}</span>
        </a>
    </li>
@endif
