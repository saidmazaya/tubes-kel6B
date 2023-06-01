<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">
                <i class="menu-icon fa-solid fa-table-cells-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Data Management</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('article.index') }}" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon fa-regular fa-newspaper"></i>
                <span class="menu-title">Articles</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#comment-basic" aria-expanded="false" aria-controls="comment-basic">
                <i class="menu-icon fa-regular fa-comment"></i>
                <span class="menu-title">Comments</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="comment-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('comment.index') }}">Articles</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="{{ route('list.index') }}">List</a></li> --}}
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Forms and Datas</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrator.index') }}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon fa-solid fa-folder-plus"></i>
                <span class="menu-title">Articles Admin</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tag.index') }}" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon fa-solid fa-tag"></i>
                <span class="menu-title">Tags</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('account.index') }}" aria-expanded="false" aria-controls="tables">
                <i class="menu-icon fa-solid fa-user"></i>
                <span class="menu-title">Accounts Tables</span>
            </a>
        </li>
    </ul>
</nav>