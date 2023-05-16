<!-- ======= Header ======= -->
<header id="header" class="fixed-top header-inner-pages">
    <div class="container" id="containernav">
        <div class="navbar d-flex align-items-center justify-content-between">
            <form method="GET" action="/menuutama" id="formNav">
                <input type="text" style="border-radius: 4px; width: 6cm; padding: 4px" name="keyword" placeholder="Search...">
                <button type="submit" style="padding: 4px" class=""><i class="bi bi-search"></i></button>
            </form>

            <nav id="navbar" class="navbar">
                <ul>
                    @if (Auth::check())
                    <li><a class="nav-link scrollto" href="/menuutama"><i class='bx bx-home-alt-2 bx-sm mb-2'></i></a></li>
                    <li><a class="nav-link scrollto" href="/write-article"><i class='bx bx-edit bx-sm mb-2'></i></a></li>
                    <li><a class="nav-link scrollto" href="/notif"><i class="bx bx-bell bx-sm mb-2"></i></a></li>
                    @if (Auth::user()->image != null)
                    <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="{{ asset('storage/photo/'.Auth::user()->image)}}" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                        @else
                    <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="/images/default-user-image.png" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                        @endif
                        <ul>
                            <li><a href="/profile/{{ Auth::user()->username }}">Profile</a></li>
                            <li><a href="/library">Library</a></li>
                            <li><a href="/stories/draft/{{ Auth::user()->username }}">Stories</a></li>
                            <li><a href="/signout">Sign Out</a></li>
                        </ul>
                    </li>
                    @else
                    <li><a class="nav-link scrollto" href="/"><i class='bx bx-home-alt-2 bx-sm mb-2'></i></a></li>
                    <li><a class="nav-link scrollto" href="/write-article"><i class='bx bx-edit bx-sm mb-2'></i></a></li>
                    <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="/images/default-user-image.png" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
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