@extends('admin.layout.main')

@section('title', 'Comment List Detail')

@section('content')

<div class="container-fluid page-body-wrapper">
    @include('admin.components.sidebar')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Comment List Details</h4>
                            <a href="{{ route('list.index') }}" class="btn btn-outline-info"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                            <section id="blog" class="blog">
                                <div class="container" data-aos="fade-up">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-12 entries">
                                            <article class="entry entry-single">
                                                <h2 class="entry-title">
                                                    <a href="#">{{ $commentList->articleList->name }}</a>
                                                </h2>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">{{ $commentList->user->name }}</a></li>
                                                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time datetime="2020-01-01">{{ $commentList->created_at->format('M d, Y') }}</time></a></li>
                                                        <li class="d-flex align-items-center"><i class="fa fa-hands-clapping"></i> <a href="#">Clap</a></li>
                                                        <i class="bi bi-hand-clap"></i>
                                                    </ul>
                                                </div>

                                                <div class="entry-content">
                                                    <h4>Comment : </h4>
                                                    <p>{!! $commentList->content !!}</p>
                                                </div>
                                            </article><!-- End blog entry -->
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="/assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endpush