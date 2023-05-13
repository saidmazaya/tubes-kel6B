@extends('layout.main')

@section('title', 'Profile')

@section('content')
<div class="container-sm">
    <form method="post">
        <div class="row" style="margin-top: 120px">
            <div class="col-md-8 align-items-center justify-content-center">
                <h1>Nama User</h1>
                <div class="d-flex flex-row align-items-center">
                    <nav class="navbar navbar-expand-lg">
                      
                        <ul class="nav navbar-nav navbar-expand-lg" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" style="color: rgb(0, 0, 0)" id="home-tab" data-toggle="tab" href="#" role="tab" aria-controls="home" aria-selected="true">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: rgb(0, 0, 0)" id="home-tab" data-toggle="tab" href="#" role="tab" aria-controls="about" aria-selected="true">About</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <hr style="border-color: black">
                <div class="tab-content" style="margin-left: 46px">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3>Home Tab Content</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae commodo quam. Aliquam
                            luctus nisi non odio commodo, at tincidunt mauris dictum.</p>
                    </div>
                    <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <h3>List Tab Content</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae commodo quam. Aliquam
                            luctus nisi non odio commodo, at tincidunt mauris dictum.</p>
                    </div>
                    <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <h3>About Tab Content</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae commodo quam. Aliquam
                            luctus nisi non odio commodo, at tincidunt mauris dictum.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="image-container">
                    <img src="img/gb.jpg" alt="" class="rounded-image">
                </div>
                <div class="profile-head">
                    <h5>Aini</h5>
                    <h6><a href="#">4 Followers</a></h6>
                    <div class="d-flex flex-row align-items-center justify-content-between mt-3">
                        <div>
                            <button class="btn btn-primary mb-4">Follow</button>

                            <div class="profile-head mt-4">
                                <div>
                                    <h6>Following</h6>
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="profile-image.jpg" alt="Follower Name" class="rounded-circle" width="30">
                                        <a href="#" class="text-dark ml-2">Follower Name</a>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="profile-image.jpg" alt="Follower Name" class="rounded-circle" width="30">
                                        <a href="#" class="text-dark ml-2 mb-5">Follower Name</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('css')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="/css/pf.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endpush
@push('css')
<style>
    #containernav {
        height: 60px;   
        max-width: 1350px;
    }
    #formNav {
        margin-bottom: 10px;
    }
</style>
@endpush