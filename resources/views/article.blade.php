<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          @foreach ($article as $item)
          <div class="card mb-5" style="border-radius: 15px;">
            <div class="card-body p-4">
              <h3 class="mb-3">{{ $item->title }}</h3>
              <p class="small mb-0"><i class="far fa-star fa-lg"></i> <span class="mx-2">|</span> Created by
                <a href="profile/{{ $item->user->username }}"><strong>{{ $item->user->username }}</strong></a> on {{ $item->created_at }}</p>
              <hr class="my-4">
              <div class="d-flex justify-content-start align-items-center">
                @foreach ($item->tags as $tags)                 
                <p class="mb-0 text-uppercase"><i class="fas fa-cog me-2"></i> <span
                    class="text-muted small">{{ $tags->name }}</span></p>
                @endforeach
                <p class="mb-0 text-uppercase"><i class="fas fa-link ms-4 me-2"></i> <span
                    class="text-muted small">program link</span></p>
                <p class="mb-0 text-uppercase"><i class="fas fa-ellipsis-h ms-4 me-2"></i> <span
                    class="text-muted small">program link</span>
                  <span class="ms-3 me-4">|</span></p>
                <a href="#!">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-2.webp" alt="avatar"
                    class="img-fluid rounded-circle me-3" width="35">
                </a>
                <button type="button" class="btn btn-outline-dark btn-sm btn-floating">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>