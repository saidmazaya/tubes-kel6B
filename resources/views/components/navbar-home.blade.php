<!-- ======= Header ======= -->
<header id="header" class="fixed-top @yield('cssnav')">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="">Premium</a></h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="/">Home</a></li>
                <li><a class="nav-link scrollto" href="/ourstory">Our Story</a></li>
                <li><a class="nav-link scrollto" href="/write">Write</a></li>
                <li><a class="nav-link scrollto" href="{{ route('signin') }}">Sign In</a></li>
                <li><a class="nav-link scrollto" href="{{ route('signup') }}">Get Started</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->