<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Premium </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
    @stack('css')
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-inner-pages">
        <div class="container">
            <div class="navbar d-flex align-items-center justify-content-between">
                <form method="GET" action="#">
                    <input type="text" style="border-radius: 4px; width: 6cm; padding: 4px" placeholder="Search...">
                    <button type="submit" style="padding: 4px" class=""><i class="bi bi-search"></i></button>
                </form>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a href="" class="btn btn-success mb-2">Publish</a></li>
                        <li><a class="nav-link scrollto" href="notif"><i class="bx bx-bell bx-sm mb-2"></i></a></li>
                        <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="path_to_profile_image" class="profile" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="#">Profile</a></li>
                                <li><a href="#">Library</a></li>
                                <li><a href="#">Stories</a></li>
                                <li><a href="#">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->
            </div>
        </div>
    </header><!-- End Header -->
    <div class="container mt-3">

        <div class="col-md-8 col-sm-12 bg-white p-4" style="margin-top: 100px">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <input type="file" class="form-control-file" name="gambar">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control" name="judul" placeholder="Judul artikel">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Isi Artikel</label>
                    <textarea class="form-control" name="deskripsi" rows="10"></textarea>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/js/main.js"></script>
    @stack('js')
</body>

</html>