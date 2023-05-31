<!-- ======= Header ======= -->
<header id="header" class="fixed-top header-inner-pages">
    <div class="container" id="containernav">
        <div class="navbar d-flex align-items-center justify-content-between">

            <h1 class="logo">
                <a href="/menuutama" style="float: left">
                    <img src="/images/premium-mini.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
                </a>
                <form method="GET" action="/menuutama" id="formNav" style="font-size: 15px; margin-left: 10px; margin-top: 3px; float: left;">
                    <input type="text" style="border-radius: 4px; width: 6cm; padding: 4px" name="keyword" placeholder="Search...">
                    <button type="submit" style="padding: 4px; height: 32px;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </h1>

            <nav id="navbar" class="navbar">
                <ul>
                    @if (Auth::check())
                    <li><a class="nav-link scrollto" href="/menuutama">Home</a></li>
                    @if (Auth::user()->role_id == 1)
                    <li><a class="nav-link scrollto" href="{{ route('administrator.create') }}">Write</a></li>
                    @else
                    <li><a class="nav-link scrollto" href="/write-article">Write</a></li>
                    @endif
                    <li><a class="nav-link scrollto" href="/notif">Notification</a></li>
                    @if (Auth::user()->image != null)
                    <li class="dropdown"><a href="#" class="nav-link scrollto">{{ Auth::user()->name }}<i class="bi bi-chevron-down"></i></a>
                        @else
                    <li class="dropdown"><a href="#" class="nav-link scrollto">{{ Auth::user()->name }}<i class="bi bi-chevron-down"></i></a>
                        @endif
                        {{-- @if (Auth::user()->image != null)
                    <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="{{ asset('storage/photo/'.Auth::user()->image)}}" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                        @else
                    <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="/images/default-user-image.png" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                        @endif --}}
                        <ul>
                            <li><a href="/profile/{{ Auth::user()->username }}">Profile</a></li>
                            <li><a href="/library/{{ Auth::user()->username }}">Library</a></li>
                            <li><a href="/stories/draft/{{ Auth::user()->username }}">Stories</a></li>
                            @if (Auth::user()->role_id == 1)
                            <li><a href="/dashboard">Dashboard</a></li>
                            @endif
                            <li><a href="{{ route('profile.change') }}">Change Password</a></li>
                            <li><a href="/signout">Sign Out</a></li>
                        </ul>
                    </li>
                    @else
                    <li><a class="nav-link scrollto" href="/">Home</a></li>
                    <li><a class="nav-link scrollto" href="/write-article">Write</a></li>
                    <li class="dropdown"><a href="#" class="nav-link scrollto mb-1">Guest<i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="/signin">Sign In</a></li>
                            <li><a href="/signup">Get Strated</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </div>
</header><!-- End Header -->