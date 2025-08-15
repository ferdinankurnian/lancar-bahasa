@if (Module::isEnabled('Testimonial') && Route::has('admin.testimonial.index'))
    <li class="{{ isRoute('admin.testimonial.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.testimonial.index') }}">
            <i class="fas fa-comment"></i> <span>{{ __('Testimonial') }}</span>
        </a>
    </li>
@endif
