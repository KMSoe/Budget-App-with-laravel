<div class="side-inner">
    <div class="profile mx-auto text-center">
        <img src='{{ asset("storage/profiles/" . Auth::user()->profile) }}' alt="{{ Auth::user()->name }}" class="img-fluid">
        <h3 class="name">{{ Auth::user()->name }}</h3>
        <span class="text-muted">({{ __( Auth::user()->role->name) }})</span>
        <span class="email text-muted">{{ Auth::user()->email }}</span>
        <!-- <a href="#" class="align-self-center btn btn-primary mt-2">Profile</a> -->
    </div>

    <div class="nav-menu">
        <ul>
            <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="{{ route('home') }}"><i class="fas fa-home me-2"></i>{{ __('Dashboard') }}</a></li>
            <li class="{{ Request::is('profile') ? 'active' : '' }}"><a href="{{ route('profile') }}"><i class="fas fa-user me-2"></i></i>{{ __('Profile') }}</a></li>
            <li class="{{ Request::is('statistics*') ? 'active' : '' }}"><a href="{{ route('statistics') }}"><i class="fas fa-chart-line me-2"></i></i>{{ __('Statistics') }}</a></li>
            <li class="{{ Request::is('categories*') ? 'active' : '' }}"><a href="{{ route('categories.index') }}"><i class="fas fa-th-large me-2"></i>{{ __('Categories') }}</a></li>

            @admin
            <li class="{{ Request::is('icons*') ? 'active' : '' }}"><a href="{{ route('icons.index') }}"><i class="fas fa-icons me-2"></i>{{ __('Icons') }}</a></li>
            @endadmin
            <li class="{{ Request::is('setting') ? 'active' : '' }}"><a href="" class="d-flex justify-content-between" data-bs-toggle="modal" data-bs-target="#language-modal">

                    <span class="d-flex">
                        <i class="fas fa-globe me-2 my-auto"></i>
                        <span class="my-auto">{{ __('Language') }}</span>
                    </span>
                    <span class="d-flex justify-content-end">
                        <span class="my-auto text-end">{{ __($locale) }}</span>
                        <i style="font-size: 22px;" class="fas fa-angle-right ms-2 my-auto"></i>
                    </span>
                </a></li>
            <li class="{{ Request::is('setting') ? 'active' : '' }}"><a href="" class="d-flex justify-content-between" data-bs-toggle="modal" data-bs-target="#unit-modal">

                    <span class="d-flex">
                        <i class="fas fa-coins me-2 my-auto"></i>
                        <span class="my-auto">{{ __('Unit') }}</span>
                    </span>
                    <span class="d-flex">
                        <span class="my-auto">{{ __($unit) }}</span>
                        <i style="font-size: 22px;" class="fas fa-angle-right ms-2 my-auto"></i>
                    </span>
                </a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>{{ __('Sign out') }}</a></li>
        </ul>
    </div>
</div>