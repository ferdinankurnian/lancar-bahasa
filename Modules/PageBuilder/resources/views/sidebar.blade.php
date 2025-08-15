@if (Module::isEnabled('PageBuilder') && Route::has('admin.page-builder.index'))
    <li class="{{ isRoute('admin.page-builder.*', 'active') }}">
        <a class="nav-link" href="{{ route('admin.page-builder.index') }}">
            <i class="fas fa-file"></i> <span>{{ __('Page Builder') }}</span>
        </a>
    </li>
@endif
