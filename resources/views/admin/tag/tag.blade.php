@extends('admin.layout.main')

@section('title', 'Tags Table')

@section('content')
<div class="container-fluid page-body-wrapper">
    @include('admin.components.sidebar')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tag Tables</h4>
                            <div class="my-3">
                                <a href="{{ route('tag.create') }}" class="btn btn-outline-info">Add Data</a>
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
                                    @if ($tag->isEmpty())
                                    <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan </div>
                                    @else
                                    <thead class="table table-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th style="width: 25%">Jumlah Artikel yang Memakai</th>
                                            <th style="width: 25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tag as $data)
                                        <tr>
                                            <td>{{ $loop->iteration + $tag->firstItem() - 1 }}</td>
                                            <td>{{ $data->name }}</td>
                                            @php
                                            $tagUseCount = DB::table('articles')->where('tag_id', $data->id)->count();
                                            @endphp
                                            <td>{{ $tagUseCount }}</td>
                                            <td>
                                                <a href="{{ route('tag.detail', $data->slug) }}" class="btn-sm text-decoration-none btn-info">Detail</a>
                                                | <a href="{{ route('tag.edit', $data->slug) }}" class="btn-sm text-decoration-none btn-primary">Edit</a>
                                                | <form class="d-inline" action="{{ route('tag.destroy', $data->id) }}" method="POST" id="deleteForm{{ $data->id }}" data-tag-id="{{ $data->id }}" data-related-articles="{{ $tagUseCount }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn-sm btn-danger delete-button">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                            {{ $tag->withQueryString()->links() }}
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
//     // Event listener for the delete button
// const deleteButtons = document.querySelectorAll('.delete-button');

// deleteButtons.forEach((button) => {
//     button.addEventListener('click', function () {
//         const form = this.parentNode;
//         const tagId = form.getAttribute('data-tag-id');
//         const relatedArticles = parseInt(form.getAttribute('data-related-articles'));

//         let confirmationMessage = 'Apakah Anda yakin ingin menghapus tag ini?';

//         if (relatedArticles > 0) {
//             confirmationMessage += ' Ada artikel yang menggunakan tag ini.';
//         }

//         Swal.fire({
//             title: 'Confirmation',
//             text: confirmationMessage,
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonText: 'Ya, Hapus',
//             cancelButtonText: 'Batal',
//             customClass: {
//                 icon: '.swal2-icon.swal2-warning', // Nama kelas CSS yang Anda tentukan
//         },
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 form.submit();
//             }
//         });
//     });
// });

// Event listener for the delete button
const deleteButtons = document.querySelectorAll('.delete-button');

deleteButtons.forEach((button) => {
    button.addEventListener('click', function () {
        const form = this.parentNode;
        const tagId = form.getAttribute('data-tag-id');
        const relatedArticles = parseInt(form.getAttribute('data-related-articles'));

        if (relatedArticles > 0) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Tag ini tidak dapat dihapus karena ada artikel yang menggunakannya.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus tag ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    icon: '.swal2-icon.swal2-warning',
                    confirmButton: 'swal2-button-confirm', // Nama kelas CSS yang Anda tentukan
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endpush