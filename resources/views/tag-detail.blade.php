@extends('layout.main')

@section('title', 'Tag Detail')

@section('content')

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">

    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">

            <div class="row ">
                @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
                @endif

                <div class="col-lg-8 entries">
                    <div class="d-flex flex-row">
                        <i class="bi bi-tags" style="font-size: 20px; margin-top: 10px"></i>
                        <h1 class="mx-3 mb-4 d-flex" style="font-weight: bolder">{{ request()->slug }}</h1>
                    </div>
                    @if (Auth::check())
                    <form action="{{ route('tag-follow.store', $tagCheck->id)}}" style="margin-left: 33px" method="POST">
                        @csrf
                        @if (Auth::user()->followsTag()->where('tag_id', $tagCheck->id)->first())
                        <button type="submit" class="btn btn-outline-success rounded-5">Unfollow</button>
                        @else
                        <button type="submit" class="btn btn-success rounded-5">Follow</button>
                        @endif
                    </form>
                    @endif
                    <hr style="color: black">

                    @foreach ($article as $data)
                    <article class="entry">

                        @if ($data->image != NULL)
                        <div class="entry-img">
                            <img src="{{ asset('storage/photo/'.$data->image)}}" alt="" class="img-fluid" width="100%">
                        </div>
                        @endif

                        <h2 class="entry-title">
                            <a href="{{ route('article.detail', $data->slug) }}">{{ $data->title }}</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <a href="{{ route('profile', $data->user->username) }}" class="d-flex align-items-center">
                                        <div class="image-container">
                                            @if ($data->user->image != null)
                                            <img src="{{ asset('storage/photo/'.$data->user->image) }}" alt="profilepicture" class="rounded-image">
                                            @else
                                            <img src="/images/default-user-image.png" alt="" class="rounded-image">
                                            @endif
                                        </div>
                                        <span style="margin-left: 8px">{{ $data->user->name }}</span>
                                    </a>
                                </li>
                                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a class="nav-link disabled" href="#"><time datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time></a></li>
                                <li class="d-flex align-items-center"><i class="fa-regular fa-hourglass-half"></i><a class="nav-link disabled" href="#">{{ $data->duration.' Minutes' }}</a></li>
                                @if ($data->tags != NULL)
                                <li class="d-flex align-items-center"><i class="bi bi-tags"></i><a href="#">{{ $data->tags->name }}</a></li>
                                @else
                                <li class="d-flex align-items-center"><i class="bi bi-tags"></i><a href="#">-</a></li>
                                @endif
                            </ul>
                        </div>

                        <div class="entry-content">
                            <p>
                                {{ $data->description }}
                            </p>
                            <div class="read-more">
                                <a href="{{ route('article.detail', $data->slug) }}">Read More</a>
                            </div>
                        </div>

                    </article><!-- End blog entry -->
                    @endforeach


                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            {{ $article->withQueryString()->links() }}
                        </ul>
                    </div>

                </div><!-- End blog entries list -->

                <div class="col-lg-4">
                    <div class="sidebar d-flex justify-content-between ">
                        <div class="d-flex flex-column">
                            <h3 class="sidebar-title fs-4">{{ $articleCount }}</h3>
                            <p class="d-flex flex-column">Stories</p>
                        </div>
                        <div class="d-flex flex-column">
                            <h3 class="sidebar-title fs-4">{{ $authorCount }}</h3>
                            <p class="d-flex flex-column">Writers</p>
                        </div>
                    </div><!-- End sidebar -->
                    <hr style="color: black">
                    <div class="sidebar">
                        <h3 class="sidebar-title">Recommended Topics</h3>
                        <div class="sidebar-item tags">
                            <ul>
                                @foreach ($tag->take(10) as $data)
                                <li><a href="{{ $data->slug }}">{{ $data->name }}</a></li>
                                @endforeach
                            </ul>
                            <a href="{{ route('tag.explore') }}">See more topics</a>
                        </div><!-- End sidebar tags-->
                    </div><!-- End sidebar -->
                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Section -->

</main><!-- End #main -->
@endsection
@push('css')
<style>
    .rounded-image {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        /* Membuat gambar menjadi bentuk bulat */
    }

    .image-container {
        width: 25px;
        /* Lebar yang diinginkan */
        height: 25px;
        /* Tinggi yang diinginkan */
        overflow: hidden;
    }
</style>
@endpush