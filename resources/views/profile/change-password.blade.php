<title>Change Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<body>


    <div class="d-flex justify-content-center align-items-center vh-100 mt-3">

        <form class="shadow w-50 p-3" action="{{ route('profile.change-password', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <h4 class="display-4  fs-1">Change Password</h4><br>
            @if (session('message_a') && session('message_b'))
            <div class="alert alert-danger" role="alert">
                {{ session('message_a') }}<br>
                {{ session('message_b') }}
            </div>
            @elseif (session('message_a'))
            <div class="alert alert-danger" role="alert">
                {{ session('message_a') }}
            </div>
            @elseif (session('message_b'))
            <div class="alert alert-danger" role="alert">
                {{ session('message_b') }}
            </div>
            @endif


            <div class="mb-3">
                <label for="oldPassword" class="form-label">Old Password</label>
                <input type="password" class="form-control" name="old_password" id="oldPassword">
                @if ($errors->has('old_password'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('old_password') as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" class="form-control" name="new_password" id="newPassword">
                @if ($errors->has('new_password'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('new_password') as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="repeatPassword" class="form-label">Repeat Password</label>
                <input type="password" class="form-control" name="repeat_password" id="repeatPassword">
                @if ($errors->has('repeat_password'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('repeat_password') as $error)
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

</body>