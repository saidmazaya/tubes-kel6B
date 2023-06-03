@extends('layout.main')

@section('title', 'Your List')

@section('content')
<div class="container mt-5" id="containera">
    <div class="row">
        <div class="col-12">
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
                                    <img src="{{ asset('storage/photo/' . $data->image) }}" alt="" class="img-fluid" width="100%">
                                </div>
                                @endif
                                <h2 class="entry-title">
                                    <a href="#">{{ $data->name }}
                                        @if ($data->visibility == 'Private')
                                        <i class="fa-solid fa-lock" style="font-size: 20px"></i>
                                        @endif
                                    </a>
                                </h2>

                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center">
                                            <a href="{{ route('profile', $data->user->username) }}" class="d-flex align-items-center">
                                                <div class="image-container">
                                                    @if ($data->user->image != null)
                                                    <img src="{{ asset('storage/photo/' . $data->user->image) }}" alt="profilepicture" class="rounded-image">
                                                    @else
                                                    <img src="/images/default-user-image.png" alt="" class="rounded-image">
                                                    @endif
                                                </div>
                                                <span style="margin-left: 8px">{{ $data->user->name }}</span>
                                            </a>
                                        </li>
                                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a class="nav-link disabled" href="#"><time datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="entry-content">
                                    <p>
                                        {{ $data->description }}
                                    </p>
                                </div>
                                <div class="entry-footer d-flex align-items-end">
                                    {{-- @php
                                    $userClap = Auth::check() ? $data->claps->where('user_id', Auth::user()->id)->first() : null;
                                    $clapCount = $data->claps->count();
                                    @endphp
                                    <ul class="tags">
                                        <li> <a href="/claplist/{{ $data->id }}" class="{{ $userClap ? ' text-primary' : '' }}"><i class="fa fa-hands-clapping me-2"></i>{{ $clapCount }} Clap</a></li>
                                    </ul> --}}
                                </div>
                                @if (Auth::user()->id == $data->user_id)
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('bookmark.edit', $data->add_id)  }}" onclick="showBookmarkModalEdit('{{ $data->id }}', event)" id="bookmarkLink" class="bookmark-btn btn btn-warning" style="margin-right: 10px">
                                        <i class="bi bi-pencil-fill"></i>
                                        Edit List Info
                                    </a>
                                    <form class="d-inline" action="{{ route('list.destroy-list-your', $data->add_id) }}" method="POST" id="deleteFormList{{ $data->id }}">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger delete-button" onclick="deleteConfirmationList({{ $data->id }})">Delete List</button>
                                    </form>
                                </div>
                                @endif

                                <div id="bookmarkListEdit-{{ $data->id }}" class="modal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bookmarkListEditLabel">Edit List</h5>
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

                            </article>
                            @endforeach
                        </div><!-- End blog entries list -->
                        <hr style="border-color: black">
                        <section id="blog" class="blog">
                            <div class="container" data-aos="fade-up">

                                <div class="row">

                                    {{-- @if ($article->isEmpty())
                                    <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan
                                    </div>
                                    @endif --}}

                                    <div class="col-lg-12 entries">

                                        @foreach ($articles as $data)
                                        <article class="entry">

                                            @if ($data->image != null)
                                            <div class="entry-img">
                                                <img src="{{ asset('storage/photo/' . $data->image) }}" alt="" class="img-fluid" width="100%">
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
                                                                <img src="{{ asset('storage/photo/' . $data->user->image) }}" alt="profilepicture" class="rounded-image">
                                                                @else
                                                                <img src="/images/default-user-image.png" alt="" class="rounded-image">
                                                                @endif
                                                            </div>
                                                            <span style="margin-left: 8px">{{ $data->user->name }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a class="nav-link disabled" href="#"><time datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time></a>
                                                    </li>
                                                    <li class="d-flex align-items-center"><i class="fa-regular fa-hourglass-half"></i><a class="nav-link disabled" href="#">{{ $data->duration . ' Minutes' }}</a>
                                                    </li>
                                                    @if ($data->tags != NULL)
                                                    <li class="d-flex align-items-center"><i class="bi bi-tags"></i><a href="{{ route('tag.detail', $data->tags->slug) }}">{{ $data->tags->name }}</a></li>
                                                    @else
                                                    <li class="d-flex align-items-center"><i class="bi bi-tags"></i><a href="#">-</a></li>
                                                    @endif
                                                    <li class="d-flex align-items-center">
                                                        @if ($data->bookmarkByUser(Auth::user(), $data->id)->exists())
                                                        <i class="bi bi-bookmark-fill"></i>
                                                        @else
                                                        <i class="bi bi-bookmark"></i>
                                                        @endif
                                                        <a href="{{ route('bookmark.add') }}" onclick="showBookmarkModal('{{ $data->id }}', event)" id="bookmarkLink" class="bookmark-btn">
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

                                            <div id="bookmarkListModal-{{ $data->id }}" class="modal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="bookmarkListModalLabel">Select or Create List </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: rgb(214, 72, 72);">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($yourList->isEmpty())
                                                            <p>You don't have any list.</p>
                                                            @else
                                                            @php
                                                            $uniqueLists = $yourList->unique('add_id');
                                                            @endphp
                                                            @foreach ($uniqueLists as $list)
                                                            <div class="card mb-2">
                                                                <form id="bookmarkListAdd" action="{{ route('bookmark.add') }}" method="POST">
                                                                    @csrf
                                                                    <div class="card-body d-flex justify-content-between">
                                                                        {{ $list->name }}
                                                                        <input type="hidden" id="list_id" name="add_id" value="{{ $list->add_id }}">
                                                                        <input type="hidden" id="listname" name="name" value="{{ $list->name }}">
                                                                        <input type="hidden" id="listDescription" name="description" value="{{ $list->description }}">
                                                                        <input type="hidden" id="article_id" name="article_id" value="{{ $data->id }}">
                                                                        <input type="hidden" name="visibility" value="{{ $list->visibility }}">

                                                                        @php
                                                                        $isArticleInList = $data->articleCheckList()->where('add_id', $list->add_id)->exists();
                                                                        @endphp

                                                                        @if ($isArticleInList)
                                                                        <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                                                        @else
                                                                        <button type="submit" class="btn btn-primary mt-2">Add</button>
                                                                        @endif
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            @endforeach
                                                            @endif

                                                            <hr style="border-color: black">
                                                            <form id="bookmarkListForm" action="{{ route('bookmark.add')}}" method="POST">
                                                                @csrf

                                                                <div class="form-group mb-3">
                                                                    <label for="listName">List Name</label>
                                                                    <input type="text" class="form-control" id="listName" name="name" required maxlength="60">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="listDescription">List Description</label>
                                                                    <textarea class="form-control" id="listDescription" name="description" maxlength="250"></textarea>
                                                                </div>
                                                                <input type="hidden" id="article_id" name="article_id" value="{{ $data->id }}">
                                                                <input type="hidden" name="add_id" value="">
                                                                <div class="form-group mb-3">
                                                                    <label for="listVisibility">List Visibility</label>
                                                                    <select name="visibility" id="listVisibility" class="form-select">
                                                                        <option value="Public">Public</option>
                                                                        <option value="Private">Private</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary mt-2">Add to List</button>
                                                            </form>
                                                        </div>
                                                    </div>
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
<script>
    function showBookmarkModalEdit(edit, event) {
            event.preventDefault();

            $('#article_id').val(edit);
            $('#bookmarkListEdit-' + edit).modal('show');
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
@endpush
@push('css')
<style>
    .swal2-button-confirm {
        margin-right: 10px !important;
    }
</style>
@endpush