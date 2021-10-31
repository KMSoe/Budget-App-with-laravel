<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} &nbsp;|&nbsp; {{ $title }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="overlay"></div>
    <div id="app">
        <!-- header start -->
        <header class="w-100">
            <div class="container-fluid">
                <nav class="">
                    <div class="row g-0">
                        <div class="col-12 col-lg-12">
                            <div class="main-nav d-flex">
                                <div class="ms-2">
                                    @auth
                                    <a href="#" type="button" class="menu-toggle d-lg-none">
                                        <i class="fas fa-bars"></i>
                                    </a>
                                    @endauth
                                    <a href="/" class="navbar-brand ms-2">
                                        <!-- {{ config('app.name', 'Laravel') }} -->
                                        {{ __('Budget') }}
                                    </a>
                                </div>

                                <ul class="nav py-2">
                                    <!-- Authentication Links -->
                                    @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                    @endif
                                    @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <img src='{{ asset("storage/profiles/" . Auth::user()->profile) }}' alt="{{ Auth::user()->name }}" class="img-fluid profile-img"> <span class="username text-white px-2 py-2 d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right bg-main" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item text-white hover" href="{{ route('profile') }}">
                                                {{ __('Profile') }}
                                            </a>
                                            <a class="dropdown-item text-white hover" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Sign out') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                    @endguest
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- header end -->

        @auth
        <!-- Sidebar Start -->
        <aside class="sidebar">
            <span class="close-sidebar-btn">
                <i class="fas fa-times"></i>
            </span>
            @include('partials/sidebar')
            
        </aside>
        <!-- Sidebar End -->
        @endauth
        <div class="container-fluid">
            <div class="row g-0">
                @auth
                <div class="col-lg-3 d-none d-lg-block">
                    <!-- Main Sidebar Start -->
                    <aside class="main-sidebar">
                        @include('partials/sidebar')
                    </aside>
                    <!-- Main Sidebar End -->
                </div>
                @endauth

                <main class="col-md-12 col-lg-9 mx-auto">
                    <div class="py-4">
                        @yield('content')
                    </div>
            </div>
        </div>

    </div>
    

    
    @auth
    @include('partials/language_switcher')
    @include('partials/unit-switcher')
    @include('partials/share')
    @include('partials/rate')
    @endauth
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

</body>

</html>