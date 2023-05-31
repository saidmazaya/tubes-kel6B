@extends('layout.main')

@section('title', 'Followers')

@section('content')
<div class="container-sm">
    <div class="row" style="margin-top: 120px">
        <div class="col-md-8 align-items-center justify-content-center">
            <div class="d-flex flex-row align-items-center">
                <nav class="navbar navbar-expand-lg">
                    <ul class="nav navbar-nav navbar-expand-lg" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-link-prof" style="color: rgb(0, 0, 0)" id="home-tab" data-toggle="tab" href="#" role="tab" aria-controls="home" aria-selected="true">Followers</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <hr style="border-color: black">
            @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
            @endif
            <div class="tab-content" style="margin-left: 46px">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h1 style="font-weight: bolder; margin-bottom: 40px">{{ $user->followers->count() }} Followers</h1>
                    <div class="profile-head mt-4">
                        <div>
                            @foreach ($followers as $data)
                            <div class="d-flex flex-row align-items-center my-2">
                                <div class="image-container-following">
                                    @if ($data->image != null)
                                    <img src="{{ asset('storage/photo/'.$data->image) }}" alt="profilepicture" class="rounded-image">
                                    @else
                                    <img src="/images/default-user-image.png" alt="" class="rounded-image">
                                    @endif
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="/profile/{{ $data->username }}" class="text-dark ml-3" style="font-weight: 600">{{ $data->name }}</a>
                                    @if ($data->bio != NULL )
                                    <span class="ml-3 text-secondary">{{ $data->bio }}</span>
                                    @else
                                    <span class="ml-3 text-secondary"></span>
                                    @endif
                                </div>
                                @if ($data->id != Auth::user()->id)
                                <div class="ml-auto d-flex align-items-center">
                                    <h6>
                                        <form action="{{ route('following.store', $data->id)}}" method="POST">
                                            @csrf
                                            @if (Auth::user()->follows()->where('following_user_id', $data->id)->first())
                                            <button type="submit" class="btn btn-outline-success rounded-5">Unfollow</button>
                                            @else
                                            <button type="submit" class="btn btn-success rounded-5">Follow</button>
                                            @endif
                                        </form>
                                    </h6>
                                </div>
                                @else
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="image-container">
                @if ($user->image != null)
                <img src="{{ asset('storage/photo/'.$user->image) }}" alt="profilepicture" class="rounded-image">
                @else
                <img src="/images/default-user-image.png" alt="" class="rounded-image">
                @endif
            </div>
            <div class="profile-head">
                <h5>{{ $user->name }}</h5>
                <h6><a href="{{ route('profile.follower', $user->username) }}">{{ $user->followers->count() }} Followers</a></h6>
                <div class="d-flex flex-row align-items-center justify-content-between mt-3">
                    <div>
                        <p>{{$user->bio}}</p>
                        @if ($user->id == Auth::user()->id)
                        <h6><a href="/profile/{{ Auth::user()->username }}/edit" class="text-success">Edit Profile</a></h6>
                        @else
                        <h6>
                            <form action="{{ route('following.store', $user->id)}}" method="POST">
                                @csrf
                                @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                <button type="submit" class="btn btn-outline-success rounded-5">Unfollow</button>
                                @else
                                <button type="submit" class="btn btn-success rounded-5">Follow</button>
                                @endif
                            </form>
                        </h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    #about-content .btn {
        margin-top: 10px;
    }

    .image-container-following {
        width: 55px;
        /* Lebar yang diinginkan */
        height: 55px;
        /* Tinggi yang diinginkan */
        overflow: hidden;
    }
</style>
@endpush