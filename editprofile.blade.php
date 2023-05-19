<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<body>


    <div class="d-flex justify-content-center align-items-center vh-100 mt-3">

        <form class="shadow w-50 p-3" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h4 class="display-4  fs-1">Profile Information</h4><br>

            <div class="mb-3">
                <label class="form-label">Photo : </label>
                <img src="{{ asset(str_replace('public', 'storage', Auth::user()->image)) }}" class="rounded-circle" style="width: 70px">
                <input type="file" class="form-control" name="image" id="image">
                <input type="text" hidden="hidden" name="image" value="">
                <button class="btn btn-success mt-3" type="submit">Update</button>
                <button class="btn btn-danger mt-3" type="delete">Remove</button>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <input type="text" class="form-control" name="bio" id="bio" value="{{ Auth::user()->bio }}">
            </div>


            <div class="mb-3 d-flex justify-content-end">
                <button type="back" class="btn btn-danger">Cancel</button>&nbsp;
                <button type="submit" class="btn btn-success">Save</button>
            </div>

        </form>
    </div>

</body>
