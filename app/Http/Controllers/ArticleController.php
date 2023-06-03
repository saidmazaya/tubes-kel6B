<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleList;
use App\Models\ClapArticle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CommentArticle;
use App\Models\ClapCommentArticle;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $article = Article::with(['tags', 'user'])
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('status', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    })
                    ->orWhereHas('tags', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    });
            })
            ->where('status', 'Published')
            ->orderBy('id', 'asc')
            ->paginate(10);
        $tag = Tag::all();

        if (Auth::check()) {
            $yourList = ArticleList::where('user_id', Auth::user()->id)
                ->where('owner_id', Auth::user()->id)
                ->get();
            return view('menuutama', compact('article', 'keyword', 'tag', 'yourList'));
        } else {
            return view('menuutama', compact('article', 'keyword', 'tag'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = Tag::select('id', 'name')->get();
        return view('main.write', compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $newName = NULL;

        if ($request->file('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = Auth::user()->username . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);
        }

        $request['image'] = $newName;
        $user = User::findOrFail($request->author_id);
        $request['slug'] = $user->username . '_' . Str::slug($request->title, '-') . '-' . rand(1000000, 9999999);
        $article = Article::create($request->all());

        $status = $article->status;

        if ($status == 'Draft') {
            $message = 'Artikel anda masuk ke dalam draft';
        } else if ($status == 'Pending') {
            $message = 'Artikel Anda Berhasil di Publish mohon tunggu persetujuan admin';
        } else {
            $message = 'Status artikel tidak dikenali';
        }

        return redirect('/menuutama')->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = Article::with(['user', 'tags', 'comments.replies', 'comments.replies.replies'])
            ->where('slug', $slug)
            ->first();

        if ($article) {
            $publishedComments = CommentArticle::with('articles', 'user')
                ->where('status', '!=', 'Rejected')
                ->where('article_id', $article->id)
                ->get();
            // dd($article->toArray());
            // dd($publishedComments->toArray());
            $clap = ClapArticle::where('article_id', $article->id)->count();
            if (Auth::check()) {
                $yourList = ArticleList::where('user_id', Auth::user()->id)
                    ->where('owner_id', Auth::user()->id)
                    ->get();
                return view('article-detail', compact('article', 'publishedComments', 'clap', 'yourList'));
            } else {
                return view('article-detail', compact('article', 'publishedComments', 'clap'));
            }
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        // Memastikan pengguna adalah penulis artikel yang sesuai
        $article = Article::with(['user', 'tags'])
            ->where('slug', $slug)->first();
        $tag = Tag::where('id', '!=', $article->tag_id)->select('id', 'name')->get();
        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        return view('main.write-edit', compact('article', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, $id)
    {
        // dd($request->all());
        $article = Article::findOrFail($id);

        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        if ($request->file('photo')) {
            $oldPhotoPath = $article->image; // Path foto lama yang disimpan dalam database

            if ($oldPhotoPath != '') {
                // Hapus foto lama dari sistem file menggunakan Storage::delete()
                Storage::disk('public')->delete('photo/' . $oldPhotoPath);
            }

            // Simpan Foto Baru
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = Auth::user()->username . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);

            $request['image'] = $newName;
        }

        if ($request->title !== $article->title) {
            // Jika nama diubah, perbarui juga slug
            $user = User::findOrFail($request->author_id);
            $request['slug'] = $user->username . '_' . Str::slug($request->title, '-') . '-' . rand(1000000, 9999999);
        }

        $article->update($request->all());

        if ($request->status == 'Draft') {
            return redirect(route('stories.draft', Auth::user()->username))->with('message', 'Perubahan Data Artikel Berhasil');
        } else {
            return redirect(route('article.detail', $article->slug))->with('message', 'Perubahan Data Artikel Berhasil');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function draft($username)
    {
        $user = User::where('username', $username)->first();
        $users = $user->id;
        $article = Article::with(['user', 'tags'])
            ->where('author_id', $users)
            ->where('status', 'Draft')
            ->get();
        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        return view('stories-draft', compact('article'));
    }

    public function destroyDraft($id)
    {
        $article = Article::findOrFail($id);

        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $article->delete();

        return redirect(route('stories.draft', Auth::user()->username))->with('message', 'Draft Article berhasil dihapus.');
    }

    public function published($username)
    {
        $user = User::where('username', $username)->first();
        $users = $user->id;
        $article = Article::with(['user', 'tags'])
            ->where('author_id', $users)
            ->where('status', 'Published')
            ->get();
        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        return view('stories-published', compact('article'));
    }

    public function destroyPublished($id)
    {
        $article = Article::findOrFail($id);

        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $article->delete();

        return redirect(route('stories.published', Auth::user()->username))->with('message', 'Article berhasil dihapus.');
    }

    public function destroyArticle($id)
    {
        $article = Article::findOrFail($id);

        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $article->delete();

        return redirect(route('profile', Auth::user()->username))->with('message', 'Article berhasil dihapus.');;
    }
}

//query sql

// index :
// -- Menampilkan artikel dengan kata kunci dan halaman (pagination)
// SELECT
//     articles.*,
//     tags.*,
//     users.*
// FROM
//     articles
// LEFT JOIN article_tags ON articles.id = article_tags.article_id
// LEFT JOIN tags ON article_tags.tag_id = tags.id
// LEFT JOIN users ON articles.user_id = users.id
// WHERE
//     (
//         articles.title LIKE '%keyword%'
//         OR articles.status LIKE '%keyword%'
//         OR users.name LIKE '%keyword%'
//         OR tags.name LIKE '%keyword%'
//     )
//     AND articles.status = 'Published'
// ORDER BY
//     articles.id ASC
// LIMIT 10;

// -- Menampilkan semua tag
// SELECT * FROM tags;

// -- Menampilkan artikel dengan kata kunci
// SELECT
//     articles.*,
//     tags.*,
//     users.*
// FROM
//     articles
// LEFT JOIN article_tags ON articles.id = article_tags.article_id
// LEFT JOIN tags ON article_tags.tag_id = tags.id
// LEFT JOIN users ON articles.user_id = users.id
// WHERE
//     (
//         articles.title LIKE '%keyword%'
//         OR articles.status LIKE '%keyword%'
//         OR users.name LIKE '%keyword%'
//         OR tags.name LIKE '%keyword%'
//     )
//     AND articles.status = 'Published'
// ORDER BY
//     articles.id ASC;


// create :

//  SELECT id, name
// FROM tags;

// store :
// INSERT INTO articles (author_id, title, content, image, slug, status, created_at, updated_at)
// VALUES ('id_pengguna', 'judul_artikel', 'konten_artikel', 'nama_gambar', 'slug_artikel', 'status_artikel', NOW(), NOW());

// show :
// SELECT
//     articles.*,
//     users.*,
//     tags.*,
//     comments.*,
// FROM
//     articles
// LEFT JOIN users ON articles.user_id = users.id
// LEFT JOIN article_tags ON articles.id = article_tags.article_id
// LEFT JOIN tags ON article_tags.tag_id = tags.id
// LEFT JOIN comments ON comments.article_id = articles.id
// WHERE
//     articles.slug = 'slug_artikel'
// LIMIT 1;

// update :
// UPDATE articles
// SET
//     title = 'judul_baru',
//     content = 'konten_baru',
//     image = 'nama_gambar_baru',
//     slug = 'slug_baru',
//     status = 'status_baru',
//     updated_at = NOW()
// WHERE
//     id = 'id_artikel';

// draft :
// SELECT articles.*
// FROM articles
// JOIN users ON articles.author_id = users.id
// WHERE users.username = {username}
//   AND articles.status = 'Draft'

// destroyDraft :
// DELETE FROM articles
// WHERE id = 'id_artikel' AND author_id = 'id_pengguna';

// -- Fungsi published()
// SELECT
//     articles.*,
//     users.*,
//     tags.*
// FROM
//     articles
// LEFT JOIN users ON articles.author_id = users.id
// LEFT JOIN article_tags ON articles.id = article_tags.article_id
// LEFT JOIN tags ON article_tags.tag_id = tags.id
// WHERE
//     articles.author_id = 'id_pengguna'
//     AND articles.status = 'Published';

// -- Fungsi destroyPublished()
// DELETE FROM articles
// WHERE
//     id = 'id_artikel'
//     AND author_id = 'id_pengguna';

// -- Fungsi destroyArticle()
// DELETE FROM articles
// WHERE
//     id = 'id_artikel'
//     AND author_id = 'id_pengguna';

