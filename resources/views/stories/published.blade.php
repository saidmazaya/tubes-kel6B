<article class="entry">
    @if($article)
    @foreach ($article as $data)
    <div class="entry-img">
        <img src="#" alt="" class="img-fluid">
    </div>
    <h2 class="entry-title" style="margin-left: 30px; font-size: 20px">
        <a href="{{ route('article.detail', $data->slug) }}">{{ $data->title }}</a>
    </h2>
    <div class="entry-meta">
        <ul>
            <li class="d-flex align-items-end"><i class="bi bi-clock"></i> <a style="color: black" class="nav-link disabled" href="#"><time datetime="2020-01-01">&nbsp;&nbsp;{{ $data->created_at->format('M d, Y') }}</time></a></li>
        </ul>
    </div>
    <div class="entry-content" style="margin-left: 30px">
        <div class="read-more d-flex justify-content-between">
            <a href="{{ route('write-article.edit', $data->slug) }}">Edit</a>
            <form class="d-inline" action="{{ route('article.destroy-published', $data->id) }}" method="POST" id="deleteForm{{ $data->id }}">
                @csrf
                @method('delete')
                <button type="button" class="btn btn-danger delete-button" onclick="deleteConfirmation({{ $data->id }})">Delete Article</button>
            </form>
        </div>
    </div>
    @endforeach
    @else
    @endif
</article><!-- End blog entry -->