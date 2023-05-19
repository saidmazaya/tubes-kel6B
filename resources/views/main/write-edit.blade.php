<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Premium </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/images/premium-mini.png" rel="icon">

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
                    <li><a class="nav-link scrollto" href="/menuutama"><i class='bx bx-home-alt-2 bx-sm mb-2'></i></a></li>
                        <li><a class="nav-link scrollto" href="notif"><i class="bx bx-bell bx-sm mb-2"></i></a></li>
                        @if (Auth::user()->image != null)
                        <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="{{ asset('storage/photo/'.Auth::user()->image)}}" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                            @else
                        <li class="dropdown"><a href="#" class="nav-link scrollto mb-1"><img src="/images/default-user-image.png" width="40" class="rounded img-fluid" alt="Profile"><i class="bi bi-chevron-down"></i></a>
                            @endif
                            <ul>
                                <li><a href="/profile/{{ Auth::user()->username }}">Profile</a></li>
                                <li><a href="/library">Library</a></li>
                                <li><a href="/stories/draft/{{ Auth::user()->username }}">Stories</a></li>
                                @if (Auth::user()->role_id == 1)
                                <li><a href="/dashboard">Dashboard</a></li>
                                @endif
                                <li><a href="/signout">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->
            </div>
        </div>
    </header><!-- End Header -->
    <div class="container mt-3 d-flex justify-content-center align-items-center">

        <div class="col-md-8 col-sm-12 bg-white p-4" style="margin-top: 100px">
            <form method="POST" action="{{ route('write-article.update', $article->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}">
                    @if ($errors->has('title'))
                    <div class=" alert alert-danger mt-2">
                        @foreach ($errors->get('title') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" cols="10" rows="3" class="form-control">{{ $article->description }}</textarea>
                    @if ($errors->has('description'))
                    <div class="alert alert-danger mt-2">
                        @foreach ($errors->get('description') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $article->content }}</textarea>
                    @if ($errors->has('content'))
                    <div class="alert alert-danger mt-2">
                        @foreach ($errors->get('content') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label for="">Foto Sekarang</label> <br>
                    @if ($article->image != '')
                    <img src="{{ asset('storage/photo/'.$article->image)}}" alt="" width="200">
                    @else
                    -
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label for="photo">Photo</label>
                    <div class="input-group">
                        <input type="file" class="form-control form-control-sm" id="photo" name="photo">
                    </div>
                    @if ($errors->has('photo'))
                    <div class="alert alert-danger mt-2">
                        @foreach ($errors->get('photo') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label for="duration" class="form-label">Duration (In Minutes)</label>
                    <input type="number" class="form-control" id="duration" name="duration" value="{{ $article->duration }}">
                    @if ($errors->has('duration'))
                    <div class=" alert alert-danger mt-2">
                        @foreach ($errors->get('duration') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <input type="hidden" name="author_id" value="{{ $article->author_id }}">
                <div class="form-group mb-3">
                    <label for="tag">Tag</label>
                    <select name="tag_id" id="tag" class="form-select">
                        @if ($article->tags != '')
                        <option value="{{ $article->tags->id }}">{{ $article->tags->name }}</option>
                        @else
                        <option value="">Select One</option>
                        @endif
                        @foreach ($tag as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('tag_id'))
                    <div class="alert alert-danger mt-2">
                        @foreach ($errors->get('tag_id') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status (Publish or Draft)</label>
                    <select name="status" id="status" class="form-select">
                        @if ($article->status == 'Published')
                        <option value="Pending">{{ $article->status }}</option>
                        @else
                        <option value="{{ $article->status }}">{{ $article->status }}</option>
                        @endif
                        @if ($article->status == 'Draft')
                        <option value="Pending">Publish</option>
                        @elseif ($article->status == 'Pending' || $article->status == 'Published')
                        <option value="Draft">Draft</option>
                        @endif
                    </select>
                    @if ($errors->has('status'))
                    <div class="alert alert-danger mt-2">
                        @foreach ($errors->get('status') as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                @if ($article->status == 'Draft')
                <a href="{{ route('stories.draft', Auth::user()->username) }}" class="btn btn-outline-secondary">Cancel</a>
                @else
                <a href="{{ route('stories.published', Auth::user()->username) }}" class="btn btn-outline-secondary">Cancel</a>
                @endif
            </form>
        </div>
    </div>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'content', {
    customConfig: '/js/ckeditor-config.js'
});
    </script>
</body>

</html>