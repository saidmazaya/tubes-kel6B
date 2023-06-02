@extends('layout.main')

@section('title', 'Tag Explore')

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

                <h3 class="mb-3 d-flex justify-content-center">Explore Topics</h3>
                <div class="d-flex justify-content-center mb-5">
                    <form method="GET" action="{{ route('tag.explore') }}" id="formNav" style="font-size: 15px; margin-left: 10px; margin-top: 3px; float: left;">
                        <input type="text" style="border-radius: 4px; width: 6cm; padding: 4px" name="keyword" placeholder="Search...">
                        <button type="submit" style="padding: 4px; height: 32px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                @if ($tag->isEmpty())
                <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan </div>
                @endif

                {{-- <div class="col-lg-8 entries">


                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            {{ $article->withQueryString()->links() }}
                        </ul>
                    </div>

                </div><!-- End blog entries list --> --}}

                <div class="entries d-flex justify-content-center align-content-center">

                    <div class="sidebar">
                        <h3 class="sidebar-title">Topics</h3>
                        <div class="sidebar-item tags">
                            <ul>
                                @foreach ($tag as $data)
                                <li><a href="{{ route('tag.detail', $data->slug) }}">{{ $data->name }}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- End sidebar tags-->
                        {{-- <div class="blog-pagination">
                            <ul class="justify-content-center">
                                {{ $tag->withQueryString()->links() }}
                            </ul>
                        </div> --}}
                    </div><!-- End sidebar -->
                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Section -->

</main><!-- End #main -->
@endsection