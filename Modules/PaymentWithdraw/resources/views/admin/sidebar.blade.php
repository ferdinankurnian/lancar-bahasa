@php
    $pendingWithdrawCount = \Modules\PaymentWithdraw\app\Models\WithdrawRequest::where('status', 'pending')->count();
@endphp
<li
    class="nav-item dropdown {{ isRoute(['admin.withdraw-method.*', 'admin.withdraw-list', 'admin.show-withdraw', 'admin.pending-withdraw-list'], 'active') }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-holding-usd"></i><span
            class="{{ $pendingWithdrawCount > 0 ? 'beep parent' : '' }}">{{ __('Withdraw Payment') }}</span></a>

    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.withdraw-method.*', 'active') }}"><a class="nav-link"
                href="{{ route('admin.withdraw-method.index') }}">{{ __('Withdraw Method') }}</a></li>

        <li class="{{ isRoute('admin.withdraw-list', 'active') }}"><a class="nav-link"
                href="{{ route('admin.withdraw-list') }}">{{ __('Withdraw list') }}
                @if ($pendingWithdrawCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingWithdrawCount }}</small>
                @endif
            </a>
        </li>
    </ul>
