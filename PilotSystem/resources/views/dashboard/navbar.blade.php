<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper">
        <a class="navbar-brand brand-logo" href="{{ route('frontend.home') }}"><img src="{{ asset('assets/images/dashboard-title.png') }}" alt="logo"></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('frontend.home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="logo title"></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <p class="page-name d-none d-lg-block">
            飞行员后台, {{ Auth::user()->callsign }}
        </p>
        <a class="nav-link" href="{{ url('/logout') }}">
            <p class="mb-0">登出</p>
        </a>
        <p class="page-name d-none d-lg-block ml-5">
            [@yield('page-name')]
        </p>
        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item lang-dropdown d-none d-sm-block">
                <a class="nav-link" href="#">
                    <p class="mb-0">English <i class="flag-icon flag-icon-gb"></i></p>
                </a>
                <a class="nav-link" href="#">
                    <p class="mb-0">中文 <i class="flag-icon flag-icon-cn"></i></p>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
            <span class="icon-menu icons"></span>
        </button>
    </div>
</nav>