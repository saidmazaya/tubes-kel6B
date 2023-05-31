@extends('layout.main')

@section('title', 'Profile')

@section('content')
    <div class="container mt-5" id="containera">
        <div class="row">
            <div class="col-8">
                <div class="d-flex justify-content-between align-items-center mt-5" style="margin-left: 30px">
                    <h1>Your List</h1>
                </div>
                <hr>
                <hr style="border-color: black">
                <section id="blog" class="blog">
                    <div class="container" data-aos="fade-up">

                        <div class="row">
                            @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif

                            {{-- @if ($articleLists->isEmpty())
                                <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan</div>
                            @endif --}}
                            <div class="col-lg-12 entries">
                                @php
                                    $articleLists = $articleLists->unique('add_id');
                                @endphp
                                @foreach ($articleLists as $data)
                                    <article class="entry">
                                        @if ($data->image != null)
                                            <div class="entry-img">
                                                <img src="{{ asset('storage/photo/' . $data->image) }}" alt=""
                                                    class="img-fluid">
                                            </div>
                                        @endif
                                        <h2 class="entry-title">
                                            <a href="">{{ $data->name }}</a>
                                        </h2>

                                        <div class="entry-meta">
                                            <ul>
                                                <li class="d-flex align-items-center">
                                                    <a href="{{ route('profile', $data->user->username) }}"
                                                        class="d-flex align-items-center">
                                                        <div class="image-container">
                                                            @if ($data->user->image != null)
                                                                <img src="{{ asset('storage/photo/' . $data->user->image) }}"
                                                                    alt="profilepicture" class="rounded-image">
                                                            @else
                                                                <img src="/images/default-user-image.png" alt=""
                                                                    class="rounded-image">
                                                            @endif
                                                        </div>
                                                        <span style="margin-left: 8px">{{ $data->user->name }}</span>
                                                    </a>
                                                </li>
                                                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a
                                                        class="nav-link disabled" href="#"><time
                                                            datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="entry-content">
                                            <p>
                                                {{ $data->description }}
                                            </p>
                                        </div>
                                        <div class="entry-content">
                                            @php
                                            $userClap = Auth::check() ? $data->claps->where('user_id', Auth::user()->id)->first() : null;
                                            $clapCount = $data->claps->count();
                                            @endphp
                                            <ul>
                                                <li class="d-flex align-items-center"> <a href="/claplist/{{ $data->id }}" class="{{ $userClap ? ' text-primary' : '' }}"><i class="fa fa-hands-clapping"></i>{{ $clapCount }} Clap</a></li>
                                            </ul>
                                        </div>
                                    </article>
                                @endforeach
                            </div><!-- End blog entries list -->
                            <hr style="border-color: black">
                            <section id="blog" class="blog">
                                <div class="container" data-aos="fade-up">

                                    <div class="row">
                                        @if (session('message'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('message') }}
                                            </div>
                                        @endif

                                        {{-- @if ($article->isEmpty())
                                            <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan
                                            </div>
                                        @endif --}}

                                        <div class="col-lg-12 entries">

                                            @foreach ($articles as $data)
                                                <article class="entry">

                                                    @if ($data->image != null)
                                                        <div class="entry-img">
                                                            <img src="{{ asset('storage/photo/' . $data->image) }}"
                                                                alt="" class="img-fluid">
                                                        </div>
                                                    @endif

                                                    <h2 class="entry-title">
                                                        <a
                                                            href="{{ route('article.detail', $data->slug) }}">{{ $data->title }}</a>
                                                    </h2>

                                                    <div class="entry-meta">
                                                        <ul>
                                                            <li class="d-flex align-items-center">
                                                                <a href="{{ route('profile', $data->user->username) }}"
                                                                    class="d-flex align-items-center">
                                                                    <div class="image-container">
                                                                        @if ($data->user->image != null)
                                                                            <img src="{{ asset('storage/photo/' . $data->user->image) }}"
                                                                                alt="profilepicture" class="rounded-image">
                                                                        @else
                                                                            <img src="/images/default-user-image.png"
                                                                                alt="" class="rounded-image">
                                                                        @endif
                                                                    </div>
                                                                    <span
                                                                        style="margin-left: 8px">{{ $data->user->name }}</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center"><i
                                                                    class="bi bi-clock"></i> <a class="nav-link disabled"
                                                                    href="#"><time
                                                                        datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time></a>
                                                            </li>
                                                            <li class="d-flex align-items-center"><i
                                                                    class="fa-regular fa-hourglass-half"></i><a
                                                                    class="nav-link disabled"
                                                                    href="#">{{ $data->duration . ' Minutes' }}</a>
                                                            </li>
                                                            @if ($data->tags != null)
                                                                <li class="d-flex align-items-center"><i
                                                                        class="bi bi-tags"></i><a
                                                                        href="#">{{ $data->tags->name }}</a></li>
                                                            @endif
                                                            <li class="d-flex align-items-center">
                                                                <i class="bi bi-bookmarks"></i>
                                                                <a href="{{ route('bookmark.add') }}"
                                                                    onclick="showBookmarkModal('{{ $data->id }}', event)"
                                                                    id="bookmarkLink" class="bookmark-btn">
                                                                    Bookmark
                                                                </a>

                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="entry-content">
                                                        <p>
                                                            {{ $data->description }}
                                                        </p>
                                                        <div class="read-more">
                                                            <a href="{{ route('article.detail', $data->slug) }}">Read
                                                                More</a>
                                                        </div>
                                                    </div>

                                                </article><!-- End blog entry -->
                                            @endforeach 

                                        </div><!-- End blog entries list -->
                                    </div>
                            </section><!-- End Blog Section -->

                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #containera {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px;
        }

        #navbarr {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #navbarr ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #navbarr li {
            margin-right: 10px;
        }

        #navbarr a {
            text-decoration: none;
            color: #333;
            padding: 8px 10px;
            border-radius: 5px;
        }

        #navbarr a:hover {
            background-color: #e9ecef;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .btn-primary {
            margin-left: 10px;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
@endpush
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