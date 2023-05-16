@extends('layout.main')

@section('title', 'Detail Article')

@section('content')

<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Blog Single Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">

      <div class="row d-flex justify-content-center align-items-center">

        <div class="col-lg-8 entries">

          <article class="entry entry-single">

            @if ($article->image != NULL)
            <div class="entry-img">
              <img src="{{ asset('storage/photo/'.$article->image)}}" alt="" class="img-fluid">
            </div>
            @endif

            <h2 class="entry-title">
              <a href="#">{{ $article->title }}</a>
            </h2>

            <div class="entry-meta">
              <ul>
                <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a class="nav-link disabled" href="#">{{ $article->user->name }}</a></li>
                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a class="nav-link disabled" href="#"><time datetime="2020-01-01">{{ $article->created_at->format('M d, Y') }}</time></a></li>
                <li class="d-flex align-items-center"><i class="fa fa-hands-clapping"></i></i> <a href="#">Clap</a></li>
                <i class="bi bi-hand-clap"></i>

              </ul>
            </div>

            <div class="entry-content">
              <p>{!! $article->content !!}</p>
            </div>

            <div class="entry-footer">
              <i class="bi bi-tags"></i>
              @if ($article->tags != NULL)
              <ul class="tags">
                <li><a href="#">{{ $article->tags->name }}</a></li>
              </ul>
              @else
              -
              @endif
            </div>

          </article><!-- End blog entry -->

          <div class="blog-comments">

            <h4 class="comments-count">8 Comments</h4>

            @foreach ($article->comments as $data)
            <div id="comment-2" class="comment">
              <div class="d-flex">
                <div class="comment-img"><img src="/assets/img/blog/comments-2.jpg" alt=""></div>
                <div>
                  <h5><a href="">{{ $data->user->name }}</a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i>
                      Reply</a></h5>
                  <time datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time>
                  <p>
                    {{ $data->content }}
                  </p>
                </div>
              </div>
              @if ($data && count($data->replies) > 0)
              @foreach ($data->replies as $data)
              <div id="comment-reply-1" class="comment comment-reply">
                <div class="d-flex">
                  <div class="comment-img"><img src="/assets/img/blog/comments-3.jpg" alt=""></div>
                  <div>
                    <h5><a href="">{{ $data->user->name }}</a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i> Reply</a></h5>
                    <time datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time>
                    <p>
                      {{ $data->content }}
                    </p>
                  </div>
                </div>
              </div>
                @endforeach
                @endif
                @endforeach


              </div><!-- End comment reply #2-->

            </div><!-- End comment reply #1-->

          </div><!-- End comment #2-->

          <div id="comment-3" class="comment">
            <div class="d-flex">
              <div class="comment-img"><img src="assets/img/blog/comments-5.jpg" alt=""></div>
              <div>
                <h5><a href="">Nolan Davidson</a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i>
                    Reply</a></h5>
                <time datetime="2020-01-01">01 Jan, 2020</time>
                <p>
                  Distinctio nesciunt rerum reprehenderit sed. Iste omnis eius repellendus quia nihil ut accusantium
                  tempore. Nesciunt expedita id dolor exercitationem aspernatur aut quam ut. Voluptatem est
                  accusamus iste at.
                  Non aut et et esse qui sit modi neque. Exercitationem et eos aspernatur. Ea est consequuntur
                  officia beatae ea aut eos soluta. Non qui dolorum voluptatibus et optio veniam. Quam officia sit
                  nostrum dolorem.
                </p>
              </div>
            </div>

          </div><!-- End comment #3 -->

          <div id="comment-4" class="comment">
            <div class="d-flex">
              <div class="comment-img"><img src="assets/img/blog/comments-6.jpg" alt=""></div>
              <div>
                <h5><a href="">Kay Duggan</a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i> Reply</a>
                </h5>
                <time datetime="2020-01-01">01 Jan, 2020</time>
                <p>
                  Dolorem atque aut. Omnis doloremque blanditiis quia eum porro quis ut velit tempore. Cumque sed
                  quia ut maxime. Est ad aut cum. Ut exercitationem non in fugiat.
                </p>
              </div>
            </div>

          </div><!-- End comment #4 -->

          <div class="reply-form">
            <h4>Leave a Reply</h4>
            <p>Your email address will not be published. Required fields are marked * </p>
            <form action="">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input name="name" type="text" class="form-control" placeholder="Your Name*">
                </div>
                <div class="col-md-6 form-group">
                  <input name="email" type="text" class="form-control" placeholder="Your Email*">
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <input name="website" type="text" class="form-control" placeholder="Your Website">
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
          </div>
        </div><!-- End blog comments -->
      </div><!-- End blog entries list -->
    </div>
    </div>
  </section><!-- End Blog Single Section -->
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
@endsection
@push('js')
<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
@endpush