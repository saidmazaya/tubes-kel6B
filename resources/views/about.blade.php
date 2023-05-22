<!DOCTYPE html>
<html>

<head>
    <title>Edit About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 mt-3">

        <form class="shadow w-50 p-3" action="{{ route('about.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h4 class="display-4  fs-1">About Information</h4><br>

            <div class="mb-3">
                <label class="form-label">About</label>
                <textarea name="about" id="about" cols="30" rows="10" class="form-control">{{ Auth::user()->about }}</textarea>
                @if ($errors->has('about'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('about') as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('profile', Auth::user()->username) }}" class="btn btn-secondary">Cancel</a>&nbsp;
                <button type="submit" class="btn btn-success">Save</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('about');
    </script>
</body>

</html>