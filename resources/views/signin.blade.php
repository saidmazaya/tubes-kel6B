<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Premium | Log In</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->

</head>
<section class="vh-50 gradient-custom">
    <div class="container py-5 h-50">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-10 col-md-8 col-lg-5 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
  
              <div class="mb-md-5 mt-md-4 pb-5">
  
                <h2 class="fw-bold mb-2 text-uppercase">Welcome Back!</h2>
                <p class="text-white-50 mb-5">Please enter your Email and password!</p>
                @if (session('message'))
                <div class="alert alert-{{ session('message')['type'] }}" role="alert">
                    {{ session('message')['content'] }}
                </div>
                @endif
                @if (session()->has('status'))
                <div class="alert alert-success">
                    {{ session()->get('status') }}
                </div>
                @endif
                  <form method="POST" action="{{ route('signin', ['redirect' => url()->current() == route('menuutama') ? route('menuutama') : null]) }}">
                    @csrf
                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" class="form-control form-control-lg" name="email" required>
                    </div>
                
                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="{{ route('password.request') }}">Forgot password?</a></p>
                
                    <button class="btn btn-outline-light btn-lg px-5 mb-3" type="submit">Sign In</button>
                
                    <div>
                        <p class="mb-0">Don't have an account? <a href="signup" class="text-white-50 fw-bold">Sign Up</a></p>
                    </div>
                </form>
                
              </div>
  
              
  
            </div>
          </div>
        </div>
      </div>
    </div>
    <style>
 .gradient-custom {
        /* fallback for old browsers */
        
        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgb(255, 255, 255), rgba(37, 117, 252, 1));
        
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgb(255, 255, 255), rgba(37, 117, 252, 1))
        }
    </style>
   
  </section>