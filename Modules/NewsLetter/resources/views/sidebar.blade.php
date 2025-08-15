<li
    class="nav-item dropdown {{ isRoute('admin.subscriber-list') || isRoute('admin.send-mail-to-newsletter') ? 'active' : '' }}">
    <a href="javascript:void()" class="nav-link has-dropdown"><i
            class="fas fa-bullhorn"></i><span>{{ __('NewsLetter') }}</span></a>

    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.subscriber-list') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.subscriber-list') }}">
                {{ __('Subscriber List') }}
            </a>
        </li>

        <li class="{{ isRoute('admin.send-mail-to-newsletter') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.send-mail-to-newsletter') }}">
                {{ __('Send bulk mail') }}
            </a>
        </li>
    </ul>
</li>
