@extends('layout.main')

@section('title', 'Notification')

@section('content')
<div class="container mt-5" id="containera">
  <div class="row">
    <div class="col-8">
      <div class="d-flex justify-content-between align-items-center mt-5" style="margin-left: 30px">
        <h1>Notification</h1>
      </div>
      <hr>
      <div class="navbar navbar-expand-lg navbar-light bg-transparent" id="navbarr">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#">All</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Responses</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <hr style="border-color: black">
    </div>
  </div>
</div>
@endsection
@push('css')
<style>
  body {
    font-family: Arial, sans-serif;
  }

  #containera {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px;
  }

  #navbarr {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
  }

  #navbarr ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
  }

  #navbarr li {
    margin-right: 10px;
  }

  #navbarr a {
    text-decoration: none;
    color: #333;
    padding: 8px 10px;
    border-radius: 5px;
  }

  #navbarr a:hover {
    background-color: #e9ecef;
  }

  h1 {
    margin: 0;
    font-size: 24px;
  }

  .btn-primary {
    margin-left: 10px;
  }

  hr {
    border: none;
    border-top: 1px solid #ddd;
    margin: 20px 0;
  }
</style>
@endpush