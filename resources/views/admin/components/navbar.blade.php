<!-- partial:partials/_navbar.html -->
<style>
    .rounded-image {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        /* Membuat gambar menjadi bentuk bulat */
    }

    .image-container {
        width: 40px;
        /* Lebar yang diinginkan */
        height: 40px;
        /* Tinggi yang diinginkan */
        overflow: hidden;
    }

    .image-container-profile {
        width: 33px;
        /* Lebar yang diinginkan */
        height: 33px;
        /* Tinggi yang diinginkan */
        overflow: hidden;
    }
</style>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="/dashboard">
                <img src="/images/PREMIUM.png" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="/dashboard">
                <img src="/images/premium-mini.png" alt="logo" />
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Welcome, <span class="text-black fw-bold">{{ Auth::user()->name }}</span></h1>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item d-none d-lg-block">
                <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                    <span class="input-group-addon input-group-prepend border-right">
                        <span class="icon-calendar input-group-text calendar-icon"></span>
                    </span>
                    <input type="text" class="form-control">
                </div>
            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::user()->image != null)
                    <div class="image-container-profile">
                        <img class="rounded-image" src="{{ asset('storage/photo/'.Auth::user()->image) }}" alt="Profile image">
                    </div>
                    @else
                    <div class="image-container-profile">
                        <img class="rounded-image" src="/images/default-user-image.png" alt="Profile image">
                    </div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        @if (Auth::user()->image != null)
                        <div class="image-container" style="margin-left: 60px">
                            <img src="{{ asset('storage/photo/'.Auth::user()->image) }}" class="rounded-image">
                        </div>
                        @else
                        <div class="image-container" style="margin-left: 60px">
                            <img src="/images/default-user-image.png" class="rounded-image">
                        </div>
                        @endif
                        <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
                        <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile', Auth::user()->username) }}"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                    <a class="dropdown-item" href="/signout"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>