@extends('layout.main')
@section('title', 'Notification')

@section('content')
  
<body>
    <div class="col-md-9 mt-4 ml-2" style="margin-left: 30px">
        <div class="col-md-9 mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Your Library</h1>
                <button class="btn btn-primary">New List</button>
            </div>
        <hr>
        <div class="navbar navbar-expand-lg navbar-light bg-transparent">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" href="#">Your lists</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Saved lists</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Highlights</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Reading history</a>
                  </li>
                </ul>
             
              </div>
            </div>
          </div>

        
    </body>
    @endsection


