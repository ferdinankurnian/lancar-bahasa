<div class="dashboard__sidebar-wrap">
    <div class="dashboard__sidebar-title mb-20">
        <h6 class="title">{{ __('Welcome') }}, {{ userAuth()->name }}</h6>
    </div>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">

            <li class="{{ Route::is('student.dashboard') ? 'active' : '' }}">
                <a href="{{ route('student.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>{{ __('Dashboard') }}</a>
            </li>

            <li class="{{ Route::is('student.orders.index') ? 'active' : '' }}">
                <a href="{{ route('student.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    {{ __('Order History') }}
                </a>
            </li>

            <li class="{{ Route::is('student.enrolled-courses') ? 'active' : '' }}">
                <a href="{{ route('student.enrolled-courses') }}">
                    <i class="fas fa-book-open"></i>{{ __('Enrolled Courses') }}</a>
            </li>
            <li class="{{ Route::is('student.reviews.index') ? 'active' : '' }}">
                <a href="{{ route('student.reviews.index') }}">
                    <i class="fas fa-star"></i>{{ __('Reviews') }}</a>
            </li>
            <li class="{{ Route::is('student.quiz-attempts') ? 'active' : '' }}">
                <a href="{{ route('student.quiz-attempts') }}">
                    <i class="fas fa-question-circle"></i>{{ __('My Quiz Attempts') }}</a>
            </li>
        </ul>
    </nav>
    <div class="dashboard__sidebar-title mt-30 mb-20">
        <h6 class="title">{{ __('User') }}</h6>
    </div>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">
            <li>
                <a href="{{ route('student.setting.index') }}">
                    <i class="fas fa-user-cog"></i>
                    {{ __('Profile Settings') }}
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); $('#logout-form').trigger('submit');">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>
            </li>
            
        </ul>
    </nav>
</div>

{{-- start admin logout form --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
{{-- end admin logout form --}}


