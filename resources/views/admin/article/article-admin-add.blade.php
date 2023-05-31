@extends('admin.layout.main')

@section('title', 'Articles Add Data')

@section('content')
<div class="container-fluid page-body-wrapper">
    @include('admin.components.sidebar')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Article</h4>
                            <form action="{{ route('administrator.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                    @if ($errors->has('title'))
                                    <div class="alert alert-danger mt-2">
                                        @foreach ($errors->get('title') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control-lg form-control"></textarea>
                                    @if ($errors->has('description'))
                                    <div class="alert alert-danger mt-2">
                                        @foreach ($errors->get('description') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                                    @if ($errors->has('content'))
                                    <div class="alert alert-danger mt-2">
                                        @foreach ($errors->get('content') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="photo">Photo</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control form-control-sm" id="photo" name="photo">
                                    </div>
                                    @if ($errors->has('photo'))
                                    <div class="alert alert-danger mt-2">
                                        @foreach ($errors->get('photo') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="duration">Duration</label>
                                    <input type="number" class="form-control" id="duration" name="duration">
                                    @if ($errors->has('duration'))
                                    <div class="alert alert-danger mt-2">
                                        @foreach ($errors->get('duration') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <input type="hidden" name="author_id" value="{{ Auth::user()->id }}">
                                <div class="form-group mb-3">
                                    <label for="tag">Tag</label>
                                    <select name="tag_id" id="tag" class="form-select">
                                        <option value="">Select One</option>
                                        @foreach ($tag as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tag_id'))
                                    <div class="alert alert-danger mt-2">
                                        @foreach ($errors->get('tag_id') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <input type="hidden" name="status" value="Published">
                                <button type="submit" class="btn btn-primary me-2">Publish</button>
                                <a href="{{ route('administrator.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'content', {
    customConfig: '/js/ckeditor-config.js'
});
//     CKEDITOR.replace('description', {
//     customConfig: '/js/ckeditor-config.js'
// });
</script>
@endpush