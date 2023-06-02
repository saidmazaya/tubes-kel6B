@extends('admin.layout.main')

@section('title', 'Comment Articles Table')

@section('content')
<div class="container-fluid page-body-wrapper">
    @include('admin.components.sidebar')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Comment Article Tables</h4>
                            @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            @endif
                            <div class="my-3 col-12 col-sm-8 col-md-5">
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="keyword" placeholder="Keyword">
                                        <button class="input-group-text btn-sm btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    @if ($commentArticle->isEmpty())
                                    <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan </div>
                                    @else
                                    <thead class="table table-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th style="width: 25%">Content</th>
                                            <th style="width: 25%">User</th>
                                            <th>Article</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($commentArticle as $data)
                                        <tr>
                                            <td>{{ $loop->iteration + $commentArticle->firstItem() - 1 }}</td>
                                            <td>{{ Str::limit($data->content, 30, '...') }}</td>
                                            <td>{{ $data->user->name }}</td>
                                            <td>{{ Str::limit($data->articles->title, 30, '...') }}</td>
                                            <td>{{ $data->status }}</td>
                                            <td>
                                                <a href="{{ route('comment.show', $data->id) }}" class="btn-sm text-decoration-none btn-info"><i class="fa-solid fa-circle-info"></i></a>
                                                {{-- | <form id="publish-form-{{ $data->id }}" action="{{ route('comment.update-status', $data->id) }}" data-status="Published" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Published">
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <button type="button" class="btn-sm text-decoration-none btn-success publish-button" data-article-id="{{ $data->id }}"><i class="fa-solid fa-check"></i></button>
                                                </form> --}}
                                                {{-- @if ($data->status == 'Published') --}}
                                                {{-- @else --}}
                                                | <form id="reject-form-{{ $data->id }}" action="{{ route('comment.update-status', $data->id) }}" data-status="Rejected" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <button type="button" class="btn-sm text-decoration-none btn-danger reject-button" data-article-id="{{ $data->id }}"><i class="fa-solid fa-x"></i></button>
                                                </form>
                                                {{-- @endif --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                            {{ $commentArticle->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function publishConfirmation(articleId) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to publish this comment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Publish',
            cancelButtonText: 'Cancel',
            customClass: {
                icon: 'swal2-icon swal2-warning',
                confirmButton: 'swal2-button-confirm',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                document.querySelector(`#publish-form-${articleId}`).submit();
            }
        });
    }

    function rejectConfirmation(articleId) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to reject this comment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel',
            customClass: {
                icon: 'swal2-icon swal2-warning',
                confirmButton: 'swal2-button-confirm',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                document.querySelector(`#reject-form-${articleId}`).submit();
            }
        });
    }

    // Event listener untuk tombol konfirmasi publish
    const publishButtons = document.querySelectorAll('.publish-button');
    publishButtons.forEach((button) => {
        button.addEventListener('click', () => {
            publishConfirmation(button.dataset.articleId);
        });
    });

    // Event listener untuk tombol konfirmasi reject
    const rejectButtons = document.querySelectorAll('.reject-button');
    rejectButtons.forEach((button) => {
        button.addEventListener('click', () => {
            rejectConfirmation(button.dataset.articleId);
        });
    });
</script>
@endpush