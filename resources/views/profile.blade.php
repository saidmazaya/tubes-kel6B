@extends('layout.main')

@section('title', 'Profile')

@section('content')
<div class="container-sm">
    <div class="row" style="margin-top: 120px">
        <div class="col-md-8 align-items-center justify-content-center">
            <div class="d-flex flex-row align-items-center">
                <nav class="navbar navbar-expand-lg">
                    <ul class="nav navbar-nav navbar-expand-lg" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-link-prof" style="color: rgb(0, 0, 0)" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-prof" style="color: rgb(0, 0, 0)" id="list-tab" data-toggle="tab" href="#list" role="list" aria-controls="list" aria-selected="true">Lists</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-prof" style="color: rgb(0, 0, 0)" id="home-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <hr style="border-color: black">
            @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
            @endif
            <div class="tab-content" style="margin-left: 46px">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <article class="entry">
                        @if($article)
                        @foreach ($article as $data)
                        @if ($data->image != NULL)
                        <div class="entry-img mt-3">
                            <img src="{{ asset('storage/photo/'.$data->image)}}" alt="" class="img-fluid">
                        </div>
                        @endif
                        <h2 class="entry-title mt-3" style="font-size: 20px;">
                            <a href="{{ route('article.detail', $data->slug) }}" style="color: black">{{ $data->title }}</a>
                        </h2>
                        <div class="entry-meta">
                            @if ($data->tags != NULL)
                            <i class="bi bi-tags mr-1"></i><a href="{{ route('tag.detail', $data->tags->slug) }}" style="color: black;">{{ $data->tags->name }}</a>
                            @else
                            <i class="bi bi-tags mr-1"></i><a href="#" style="color: black;">-</a></li>
                            @endif
                            <a style="color: black; pointer-events: none; cursor: default; text-decoration: none" href="#"><time datetime="2020-01-01">&nbsp;&nbsp;{{ $data->created_at->diffForHumans() }}</time></a>
                        </div>
                        @if (Auth::user()->id == $user->id)
                        <div class="entry-content mt-4 mb-2">
                            <div class="read-more d-flex justify-content-between">
                                <a href="{{ route('write-article.edit', $data->slug) }}">Edit</a>
                                <form class="d-inline" action="{{ route('write-article.destroy-article', $data->id) }}" method="POST" id="deleteForm{{ $data->id }}">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger delete-button" onclick="deleteConfirmation({{ $data->id }})">Delete Article</button>
                                </form>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @else
                        @endif
                    </article><!-- End blog entry -->
                </div>
                <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                    <h3>List Tab Content</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae commodo quam. Aliquam
                        luctus nisi non odio commodo, at tincidunt mauris dictum.</p>
                </div>
                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <div id="about-content">
                        @if ($user->about != NULL)
                        {!! $user->about !!}
                        @endif
                        @if (Auth::user()->id == $user->id)
                        <h6 class="d-flex justify-content-end"><a href="/profile/{{ Auth::user()->username }}/about" class="btn btn-outline-dark">Edit About</a></h6>
                        @endif
                        <hr style="border-color: black">
                        <h6><a href="{{ route('profile.follower', $user->username) }}" style="color: green">{{ $user->followers->count() }} Followers</a><span class="mx-2">&sdot;</span><a href="{{ route('profile.following', $user->username) }}"
                                style="color: green">{{ $user->follows->count() }} Following</a></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="image-container">
                @if ($user->image != null)
                <img src="{{ asset('storage/photo/'.$user->image) }}" alt="profilepicture" class="rounded-image">
                @else
                <img src="/images/default-user-image.png" alt="" class="rounded-image">
                @endif
            </div>
            <div class="profile-head">
                <h5>{{ $user->name }}</h5>
                <h6><a href="{{ route('profile.follower', $user->username) }}">{{ $user->followers->count() }} Followers</a></h6>
                <div class="d-flex flex-row align-items-center justify-content-between mt-3">
                    <div>
                        <p>{{$user->bio}}</p>
                        @if ($user->id == Auth::user()->id)
                        <h6><a href="/profile/{{ Auth::user()->username }}/edit" class="text-success">Edit Profile</a></h6>
                        @else
                        <h6>
                            <form action="{{ route('following.store', $user->id)}}" method="POST">
                                @csrf
                                @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                <button type="submit" class="btn btn-outline-success rounded-5">Unfollow</button>
                                @else
                                <button type="submit" class="btn btn-success rounded-5">Follow</button>
                                @endif
                            </form>
                        </h6>
                        @endif
                        <div class="profile-head mt-4">
                            <div>
                                <h6>Following</h6>
                                @foreach ($user->follows->take(5) as $data)
                                <div class="d-flex flex-row align-items-center my-2">
                                    <div class="image-container-following">
                                        @if ($data->image != null)
                                        <img src="{{ asset('storage/photo/'.$data->image) }}" alt="profilepicture" class="rounded-image">
                                        @else
                                        <img src="/images/default-user-image.png" alt="" class="rounded-image">
                                        @endif
                                    </div>
                                    <a href="/profile/{{ $data->username }}" class="text-dark ml-2">{{ $data->name }}</a>
                                </div>
                                @endforeach
                                <a href="{{ route('profile.following', $user->username) }}" class="text-secondary mt-2">See All ({{ $user->follows->count() }})</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="/css/pf.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endpush
@push('css')
<style>
    #containernav {
        height: 60px;
        max-width: 1350px;
    }

    #formNav {
        margin-bottom: 10px;
    }

    #about-content .btn {
        margin-top: 10px;
    }

    .image-container-following {
        width: 30px;
        /* Lebar yang diinginkan */
        height: 30px;
        /* Tinggi yang diinginkan */
        overflow: hidden;
    }
</style>
@endpush
@push('js')
<script>
    $(document).ready(function() {
        $('.nav-link-prof').click(function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $('.tab-pane').removeClass('show active');
            $(target).addClass('show active');
        });
    });
</script>

<script>
    // Fungsi untuk menampilkan SweetAlert konfirmasi
    function deleteConfirmation(articleId) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to delete this Article?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            customClass: {
                icon: 'swal2-icon swal2-warning',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                document.querySelector(`#deleteForm${articleId}`).submit();
            }
        });
    }
</script>
@endpush