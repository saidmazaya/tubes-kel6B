@extends('admin.layout.main')

@section('title', 'Admin Dashboard')

@section('content')
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_settings-panel.html -->
  @include('admin.components.sidebar')

  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-sm-12">
          <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
            </div>
            <div class="tab-content tab-content-basic">
              <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="statistics-details d-flex align-items-center justify-content-between">
                      <div>
                        <p class="statistics-title">Total User</p>
                        @php
                        $articleCount = DB::table('articles')->count();
                        $articleAdminCount = DB::table('users')
                        ->join('articles', 'users.id', '=', 'articles.author_id')
                        ->where('users.role_id', 1)
                        ->count();
                        $userCount = DB::table('users')->count();
                        $tagCount = DB::table('tags')->count();
                        @endphp
                        <h3 class="rate-percentage">{{ $userCount }}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Total Article</p>
                        <h3 class="rate-percentage">{{ $articleCount }}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Total Admin Article</p>
                        <h3 class="rate-percentage">{{ $articleAdminCount }}</h3>
                      </div>
                      <div class="d-none d-md-block">
                        <p class="statistics-title">Total Tag</p>
                        <h3 class="rate-percentage">{{ $tagCount }}</h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="/" target="_blank">Make Your Article</a> from Premium.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2023. All rights reserved.</span>
      </div>
    </footer>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
@endsection