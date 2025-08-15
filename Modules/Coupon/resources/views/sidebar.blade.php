<li class="nav-item dropdown {{ isRoute(['admin.coupon.index', 'admin.coupon-history'], 'active') }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill-wave"></i>
        <span>{{ __('Manage Coupon') }} </span>

    </a>
    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.coupon.index', 'active') }}"><a class="nav-link" href="{{ route('admin.coupon.index') }}">{{ __('Coupon List') }}</a></li>
    </ul>
</li>
