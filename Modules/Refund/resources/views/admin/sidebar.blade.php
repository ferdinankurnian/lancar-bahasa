<li
    class="nav-item dropdown {{ isRoute(['admin.refund-request', 'admin.pending-refund-request', 'admin.show-refund-request', 'admin.rejected-refund-request', 'admin.complete-refund-request'], 'active') }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-undo"></i>
        <span>{{ __('Manage Refund') }} </span>

    </a>
    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.refund-request', 'active') }}"><a class="nav-link"
                href="{{ route('admin.refund-request') }}">{{ __('Refund History') }}</a></li>

        <li class="{{ isRoute('admin.pending-refund-request', 'active') }}"><a class="nav-link"
                href="{{ route('admin.pending-refund-request') }}">{{ __('Pending Refund') }}</a></li>

        <li class="{{ isRoute('admin.rejected-refund-request', 'active') }}"><a class="nav-link"
                href="{{ route('admin.rejected-refund-request') }}">{{ __('Rejected Refund') }}</a></li>

        <li class="{{ isRoute('admin.complete-refund-request', 'active') }}"><a class="nav-link"
                href="{{ route('admin.complete-refund-request') }}">{{ __('Complete Refund') }}</a></li>

    </ul>
</li>
