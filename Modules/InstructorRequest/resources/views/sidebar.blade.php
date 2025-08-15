@php
    $pendingRequestCount = \Modules\InstructorRequest\app\Models\InstructorRequest::where('status', 'pending')->count();
@endphp
<li
    class="nav-item dropdown {{ isRoute(['admin.instructor-request-setting.*', 'admin.instructor-request.*'], 'active') }}">
    <a href="javascript:void()" class="nav-link has-dropdown"><i class="fas fa-chalkboard-teacher"></i><span
            class="{{ $pendingRequestCount > 0 ? 'beep parent' : '' }}">{{ __('Instructor Requests') }}</span></a>

    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.instructor-request.*', 'active') }}">
            <a class="nav-link" href="{{ route('admin.instructor-request.index') }}">
                {{ __('Request List') }}
                @if ($pendingRequestCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingRequestCount }}</small>
                @endif
            </a>
        </li>

        <li class="{{ isRoute('admin.instructor-request-setting.*', 'active') }}">
            <a class="nav-link" href="{{ route('admin.instructor-request-setting.index', ['code' => 'en']) }}">
                {{ __('Request Settings') }}
            </a>
        </li>

    </ul>
</li>
