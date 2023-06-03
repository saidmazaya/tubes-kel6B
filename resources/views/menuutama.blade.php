@extends('layout.main')

@section('title', 'Main')

@section('content')

<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">

  </section><!-- End Breadcrumbs -->

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">

      <div class="row ">
        @if (session('message'))
        <div class="alert alert-success" role="alert">
          {{ session('message') }}
        </div>
        @endif

        @if ($article->isEmpty())
        <div class="alert alert-danger">Pencarian {{ $keyword }} tidak ditemukan </div>
        @endif

        <div class="col-lg-8 entries">

          @foreach ($article as $data)
          <article class="entry">

            @if ($data->image != NULL)
            <div class="entry-img">
              <img src="{{ asset('storage/photo/'.$data->image)}}" alt="" class="img-fluid" width="100%">
            </div>
            @endif

            <h2 class="entry-title">
              <a href="{{ route('article.detail', $data->slug) }}">{{ $data->title }}</a>
            </h2>

            <div class="entry-meta">
              <ul>
                <li class="d-flex align-items-center">
                  <a href="{{ route('profile', $data->user->username) }}" class="d-flex align-items-center">
                    <div class="image-container">
                      @if ($data->user->image != null)
                      <img src="{{ asset('storage/photo/'.$data->user->image) }}" alt="profilepicture" class="rounded-image">
                      @else
                      <img src="/images/default-user-image.png" alt="" class="rounded-image">
                      @endif
                    </div>
                    <span style="margin-left: 8px">{{ $data->user->name }}</span>
                  </a>
                </li>
                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a class="nav-link disabled" href="#"><time datetime="2020-01-01">{{ $data->created_at->format('M d, Y') }}</time></a></li>
                <li class="d-flex align-items-center"><i class="fa-regular fa-hourglass-half"></i><a class="nav-link disabled" href="#">{{ $data->duration.' Minutes' }}</a></li>
                @if ($data->tags != NULL)
                <li class="d-flex align-items-center"><i class="bi bi-tags"></i><a href="{{ route('tag.detail', $data->tags->slug) }}">{{ $data->tags->name }}</a></li>
                @else
                <li class="d-flex align-items-center"><i class="bi bi-tags"></i><a href="#">-</a></li>
                @endif
                @if (Auth::check())                    
                <li class="d-flex align-items-center">
                  @if ($data->bookmarkByUser(Auth::user(), $data->id)->exists())
                  <i class="bi bi-bookmark-fill"></i>
                  @else
                  <i class="bi bi-bookmark"></i>
                  @endif
                  <a href="{{ route('bookmark.add') }}" onclick="showBookmarkModal('{{ $data->id }}', event)" id="bookmarkLink" class="bookmark-btn">
                    Bookmark
                  </a>
                </li>
                @endif
              </ul>
            </div>
            <div class="entry-content">
              <p>
                {{ $data->description }}
              </p>
              <div class="read-more">
                <a href="{{ route('article.detail', $data->slug) }}">Read More</a>
              </div>
            </div>

            @if (Auth::check())           
            <div id="bookmarkListModal-{{ $data->id }}" class="modal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="bookmarkListModalLabel">Select or Create List </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: rgb(214, 72, 72);">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    @if ($yourList->isEmpty())
                    <p>You don't have any list.</p>
                    @else
                    @php
                    $uniqueLists = $yourList->unique('add_id');
                    @endphp
                    @foreach ($uniqueLists as $list)
                    <div class="card mb-2">
                      <form id="bookmarkListAdd" action="{{ route('bookmark.add') }}" method="POST">
                        @csrf
                        <div class="card-body d-flex justify-content-between">
                          {{ $list->name }}
                          <input type="hidden" id="list_id" name="add_id" value="{{ $list->add_id }}">
                          <input type="hidden" id="listname" name="name" value="{{ $list->name }}">
                          <input type="hidden" id="listDescription" name="description" value="{{ $list->description }}">
                          <input type="hidden" id="article_id" name="article_id" value="{{ $data->id }}">
                          <input type="hidden" name="visibility" value="{{ $list->visibility }}">

                          @php
                          $isArticleInList = $data->articleCheckList()->where('add_id', $list->add_id)->exists();
                          @endphp

                          @if ($isArticleInList)
                          <button type="submit" class="btn btn-danger mt-2">Delete</button>
                          @else
                          <button type="submit" class="btn btn-primary mt-2">Add</button>
                          @endif
                        </div>
                      </form>
                    </div>
                    @endforeach
                    @endif

                    <hr style="border-color: black">
                    <form id="bookmarkListForm" action="{{ route('bookmark.add')}}" method="POST">
                      @csrf

                      <div class="form-group mb-3">
                        <label for="listName">List Name</label>
                        <input type="text" class="form-control" id="listName" name="name" required maxlength="60">
                      </div>
                      <div class="form-group mb-3">
                        <label for="listDescription">List Description</label>
                        <textarea class="form-control" id="listDescription" name="description" maxlength="250"></textarea>
                      </div>
                      <input type="hidden" id="article_id" name="article_id" value="{{ $data->id }}">
                      <input type="hidden" name="add_id" value="">
                      <div class="form-group mb-3">
                        <label for="listVisibility">List Visibility</label>
                        <select name="visibility" id="listVisibility" class="form-select">
                          <option value="Public">Public</option>
                          <option value="Private">Private</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary mt-2">Add to List</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif

          </article><!-- End blog entry -->
          @endforeach


          <div class="blog-pagination">
            <ul class="justify-content-center">
              {{ $article->withQueryString()->links() }}
            </ul>
          </div>

        </div><!-- End blog entries list -->

        <div class="col-lg-4">
          @if (Auth::check())
          <div class="sidebar">
            <h3 class="sidebar-title">Your Topics</h3>
            <div class="sidebar-item tags">
              <ul>
                @if (Auth::user()->followsTag != '[]')
                @foreach (Auth::user()->followsTag as $data)
                <li><a href="{{ route('tag.detail', $data->slug) }}">{{ $data->name }}</a></li>
                @endforeach
                @else
                Follow Some Topics That You Like, It will appear here !!
                @endif
              </ul>
            </div><!-- End sidebar tags-->
          </div><!-- End sidebar -->
          @else
          @endif

          <div class="sidebar">
            <h3 class="sidebar-title">Recommended Topics</h3>
            <div class="sidebar-item tags">
              <ul>
                @foreach ($tag->take(10) as $data)
                <li><a href="{{ route('tag.detail', $data->slug) }}">{{ $data->name }}</a></li>
                @endforeach
              </ul>
              <a href="{{ route('tag.explore') }}">See more topics</a>
            </div><!-- End sidebar tags-->
          </div><!-- End sidebar -->
        </div><!-- End blog sidebar -->

      </div>

    </div>
  </section><!-- End Blog Section -->

</main><!-- End #main -->
@endsection
@push('css')
<style>
  .rounded-image {
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    /* Membuat gambar menjadi bentuk bulat */
  }

  .image-container {
    width: 25px;
    /* Lebar yang diinginkan */
    height: 25px;
    /* Tinggi yang diinginkan */
    overflow: hidden;
  }
</style>
@endpush
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script>
<script>
  function showBookmarkModal(article, event) {
            event.preventDefault();

            $('#article_id').val(article);
            $('#bookmarkListModal-' + article).modal('show');
        }
</script>
@endpush