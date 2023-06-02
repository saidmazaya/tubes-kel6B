<title>Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<body>


    <div class="d-flex justify-content-center align-items-center vh-100 mt-3">

        <form class="shadow w-50 p-3" action="{{ route('password.email') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h4 class="display-4  fs-1">Forgot Your Password</h4><br>
            <p>Please Enter Your Email Adress, We will send link to reset your password</p>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session()->get('status') }}
            </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email">
                @if ($errors->has('email'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('email') as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Email Password Reset Link</button>
            </div>

        </form>
    </div>

</body>