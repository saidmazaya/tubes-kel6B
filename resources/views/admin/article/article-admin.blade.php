@extends('admin.layout.main')

@section('title', 'Articles Admin Table')

@section('content')
<div class="container-fluid page-body-wrapper">
    @include('admin.components.sidebar')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Article Admin Tables</h4>
                            <div class="my-3">
                                <a href="{{ route('administrator.create') }}" class="btn btn-outline-info">Add Data</a>
                            </div>
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
                                    @if ($article->isEmpty())
                                    <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan </div>
                                    @else
                                    <thead class="table table-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th style="width: 25%">Title</th>
                                            <th style="width: 25%">Author</th>
                                            <th>Tag</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($article as $data)
                                        <tr>
                                            <td>{{ $loop->iteration + $article->firstItem() - 1 }}</td>
                                            <td>{{ Str::limit($data->title, 50, '...') }}</td>
                                            <td>{{ $data->user->name }}</td>
                                            @if ($data->tags)
                                            <td>{{ $data->tags->name }}</td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            <td>
                                                <a href="{{ route('administrator.show', $data->slug) }}" class="btn-sm text-decoration-none btn-info"><i class="fa-solid fa-circle-info"></i></a>
                                                | <a href="{{ route('administrator.edit', $data->slug) }}" class="btn-sm text-decoration-none btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                                | <form class="d-inline" action="{{ route('administrator.destroy', $data->id) }}" method="POST" id="deleteForm{{ $data->id }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn-sm btn-danger delete-button" onclick="deleteConfirmation({{ $data->id }})"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                            {{ $article->withQueryString()->links() }}
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
    // Fungsi untuk menampilkan SweetAlert konfirmasi
    function deleteConfirmation(articleId) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to delete this article?',
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
@endpush