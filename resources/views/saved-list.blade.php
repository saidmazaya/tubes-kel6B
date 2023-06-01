@extends('layout.main')

@section('title', 'Library')

@section('content')
<div class="container mt-5" id="containera">
    <div class="row">
        <div class="col-8">
            <div class="d-flex justify-content-between align-items-center mt-5" style="margin-left: 30px">
                <h1>Your Library</h1>
            </div>
            <hr>
            <div class="navbar navbar-expand-lg navbar-light bg-transparent" id="navbarr">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('library', Auth::user()->username) }}">Your lists</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('library.saved', Auth::user()->username) }}">Saved lists</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="highlights">Highlights</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="reading-history">Reading history</a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <hr style="border-color: black">
            @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
            @endif

            @if ($userList->isEmpty())
            <p>You don't have any list.</p>
            @else
            @php
            $uniqueLists = $userList->unique('add_id');
            @endphp
            @foreach ($uniqueLists as $data)
            <div class="card mb-3" id="your-list">
                <div class="card-body">
                    <div>
                        <a href="{{ route('profile', $data->owner->username) }}" class="d-flex align-items-center">
                            <div class="image-container">
                                @if ($data->owner->image != null)
                                <img src="{{ asset('storage/photo/' . $data->owner->image) }}" alt="profilepicture" class="rounded-image">
                                @else
                                <img src="/images/default-user-image.png" alt="" class="rounded-image">
                                @endif
                            </div>
                            <span style="margin-left: 8px">{{ $data->owner->name }}</span>
                        </a>
                    </div>
                    <h5 class="card-title mt-3">{{ $data->name }}
                        @if ($data->visibility == 'Private')
                        <i class="fa-solid fa-lock" style="font-size: 15px"></i>
                        @endif
                    </h5>
                    <p class="card-text">{{ $data->description }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="/yourlist/{{$data->add_id}}/{{ $data->owner->username }}" class="btn btn-primary bookmark-btn" data-article-id="{{ $data->add_id }}">
                            Check List
                        </a>
                        @if (Auth::user()->id == $data->user_id)
                        <div class="d-flex justify-content-end">
                            @if ($data->bookmarkByUser(Auth::user(), $data->owner_id, $data->add_id)->exists())
                            <form class="d-inline" method="POST" action="{{ route('other-list.destroy', [$data->owner_id, $data->add_id]) }}" class="bookmark-btn">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn">
                                    <i class="bi bi-bookmark-fill"></i>
                                </button>
                            </form>
                            @else
                            <form class="d-inline" method="POST" action="{{ route('other-list.add', [$data->owner_id, $data->add_id]) }}" class="bookmark-btn">
                                @csrf
                                <button type="submit" class="btn">
                                    <i class="bi bi-bookmark-plus"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                </div>
            </div>
            @endforeach
            @endif
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
@push('scripts')
<script>
    $(document).ready(function() {
            $('.bookmark-btn').click(function() {
                var articleId = $(this).data('article-id');

                $.ajax({
                    url: '/bookmark/toggle',
                    type: 'POST',
                    data: {
                        article_id: articleId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
</script>
@endpush
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script>
<script>
    function showBookmarkModal(article, event) {
            event.preventDefault();

            $('#article_id').val(article);
            $('#bookmarkListModal-' + article).modal('show');
        }
</script>
@endpush
@push('css')
<style>
    .swal2-button-confirm {
        margin-right: 10px !important;
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