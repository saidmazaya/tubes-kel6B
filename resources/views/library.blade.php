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
                        @if (Auth::user()->id == $data->user_id)
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('bookmark.edit', $data->add_id)  }}" onclick="showBookmarkModal('{{ $data->id }}', event)" id="bookmarkLink" class="bookmark-btn btn btn-warning" style="margin-right: 10px">
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
                            <h5 class="modal-title" id="bookmarkListModalLabel">Edit List Info</h5>
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