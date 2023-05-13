@extends('layout.home')

@section('title', 'Login')

@section('content')
<section class="vh-50 gradient-custom">
  <div class="container py-5 h-50">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-10 col-md-8 col-lg-5 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Join Premium</h2>
              <p class="text-white-50 mb-5">Please enter your Email and password!</p>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typeEmailX">Email</label>
                <input type="email" id="typeEmailX" class="form-control form-control-lg" />
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typePasswordX">Password</label>
                <input type="password" id="typePasswordX" class="form-control form-control-lg" />
              </div>
              <div class="form-outline form-white mb-4">
                <label class="form-label" for="typePasswordX">Konfirmasi Password</label>
                <input type="password" id="typePasswordX" class="form-control form-control-lg" />
              </div>
              <button class="btn btn-outline-light btn-lg px-5 mb-3" type="submit">Sign Up</button>
              <div>
                <p class="mb-0">Already have an account? <a href="signin" class="text-white-50 fw-bold">Sign In</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('css')
<style>
  .gradient-custom {
    /* fallback for old browsers */

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgb(255, 255, 255), rgba(37, 117, 252, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgb(255, 255, 255), rgba(37, 117, 252, 1))
  }
</style>
@endpush