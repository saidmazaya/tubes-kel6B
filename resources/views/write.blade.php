@extends('layout.home')

@section('title', 'Start Writing')

@section('content')
<!-- ======= Services Section ======= -->
<section id="services" class="services mt-5">
  <div class="container">

    <div class="section-title">
      <h2>Write</h2>
      <h3>START A BLOG FOR<span> FREE</span></h3>
      <p>Publish, grow, and earn, all in one place.</p>
    </div>

    <div class="row">

      <div class="col-md-8 col-lg-20 d-flex align-items-stretch mb-5 mb-lg-0">
        <div class="icon-box">
          <div class="icon"><i class="bx bx-file"></i></div>
          <h4 class="title"><a href="">Write Your Article</a></h4>
          <p class="description">If you have a story to tell, knowledge to share, or a perspective to offer — welcome home. Sign up for free so your writing can thrive in a network supported by millions of readers — not ads.</p>
        </div>
      </div>


    </div>

  </div>
</section><!-- End Services Section -->

<!-- ======= Features Section ======= -->
<section id="features" class="features">
  <div class="container">

    <div class="row">
      <div class="col-lg-3 col-md-4 col-6 col-6">
        <div class="icon-box">
          <i class="bx bxs-pencil" style="color: #1c71f1;"></i>
          <h3><a href="/write-article">Start Writing</a></h3>
        </div>
      </div>

    </div>
  </div>

  </div>
</section><!-- End Features Section -->
@endsection
@section('cssnav', 'header-inner-pages')