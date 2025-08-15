@if (Module::isEnabled('Language') && Route::has('admin.course.index'))
    @php
        $pendingCourseCount = \App\Models\Course::where('is_approved', 'pending')->count();
    @endphp
    <li
        class="nav-item dropdown {{ isRoute(['admin.courses.*', 'admin.course-category.*', 'admin.course-filter.*', 'admin.course-language.*', 'admin.course-level.*', 'admin.course-review.*', 'admin.course-delete-request.*', 'admin.course-sub-category.*'], 'active') }}">
        <a href="javascript:void()" class="nav-link has-dropdown"><i
                class="fas fa-graduation-cap"></i><span class="{{ $pendingCourseCount > 0 ? 'beep parent' : '' }}">{{ __('Manage Courses') }}</span></a>

        <ul class="dropdown-menu">
            <li class="{{ isRoute('admin.courses.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courses.index') }}">
                    {{ __('Courses') }}
                    @if ($pendingCourseCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingCourseCount }}</small>
                    @endif
                </a>
            </li>
            <li class="{{ isRoute('admin.course-category.*', 'active') }} {{ isRoute('admin.course-sub-category.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-category.index') }}">
                    {{ __('Categories') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.course-language.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-language.index') }}">
                    {{ __('languages') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.course-level.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-level.index') }}">
                    {{ __('levels') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.course-review.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-review.index') }}">
                    {{ __('Course Reviews') }}
                </a>
            </li>
            <li class="{{ isRoute('admin.course-delete-request.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-delete-request.index') }}">
                    {{ __('Course Delete Requests') }}
                </a>
            </li>
        </ul>
    </li>
@endif
