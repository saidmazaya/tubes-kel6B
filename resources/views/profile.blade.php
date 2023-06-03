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
                            <img src="{{ asset('storage/photo/'.$data->image)}}" alt="" class="img-fluid" width="100%">
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
                    @if ($userList->isEmpty())
                    <p>Empty list.</p>
                    @else
                    @php
                    $uniqueLists = $userList->unique('add_id');
                    @endphp
                    @foreach ($uniqueLists as $data)
                    <div class="card mb-3" id="your-list">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->name }}
                                @if ($data->visibility == 'Private')
                                <i class="fa-solid fa-lock" style="font-size: 15px"></i>
                                @endif
                            </h5>
                            <p class="card-text">{{ $data->description }}</p>
                            <div class="d-flex justify-content-between">
                                <a href="/yourlist/{{$data->add_id}}/{{ $data->user->username }}" class="btn btn-primary bookmark-btn" data-article-id="{{ $data->add_id }}">
                                    Check List
                                </a>
                                @if (Auth::user()->id != $data->user_id)
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
                                @if (Auth::user()->id == $user->id)
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('bookmark.edit', $data->add_id)  }}" onclick="showBookmarkModal('{{ $data->id }}', event)" id="bookmarkLink" class="bookmark-btn btn btn-warning mr-2">
                                        <i class="bi bi-pencil-fill"></i>
                                        Edit List Info
                                    </a>
                                    <form class="d-inline" action="{{ route('list.destroy-list', $data->add_id) }}" method="POST" id="deleteFormList{{ $data->id }}">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger delete-button" onclick="deleteConfirmationList({{ $data->id }})">Delete List</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="bookmarkListModal-{{ $data->id }}" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookmarkListModalLabel">Edit List</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: rgb(214, 72, 72);">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="bookmarkListForm" action="{{ route('bookmark.edit', $data->add_id) }}" method="POST">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="listName">List Name</label>
                                            <input type="text" class="form-control" id="listName" name="name" value="{{ $data->name }}" required maxlength="60">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="listDescription">List Description</label>
                                            <textarea class="form-control" id="listDescription" name="description" maxlength="250">{{ $data->description }}</textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="listVisibility">List Visibility</label>
                                            <select name="visibility" id="listVisibility" class="form-select">
                                                <option value="{{ $data->visibility }}">{{ $data->visibility }}</option>
                                                @if ($data->visibility == 'Public')
                                                <option value="Private">Private</option>
                                                @else
                                                <option value="Public">Public</option>
                                                @endif
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
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
{{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
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
                confirmButton: 'swal2-button-confirm',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                document.querySelector(`#deleteForm${articleId}`).submit();
            }
        });
    }
</script>

<script>
    // Fungsi untuk menampilkan SweetAlert konfirmasi
    function deleteConfirmationList(articleId) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to delete this List?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            customClass: {
                icon: 'swal2-icon swal2-warning',
                confirmButton: 'swal2-button-confirm',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                document.querySelector(`#deleteFormList${articleId}`).submit();
            }
        });
    }
</script>

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