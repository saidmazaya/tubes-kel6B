<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\ClapArticle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ArticleAdminEditRequest;

class ArticleAdminEditController extends Controller
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
            ->whereHas('user', function ($query) {
                $query->where('role_id', '!=', 2);

                // AND users.role_id != 2
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('admin.article.article-admin', compact('article', 'keyword'));

        // -- Menampilkan artikel berdasarkan kata kunci
        // SELECT *
        // FROM articles
        // JOIN tags ON articles.tag_id = tags.id
        // JOIN users ON articles.author_id = users.id
        // WHERE (articles.title LIKE '%<keyword>%' OR articles.status LIKE '%<keyword>%' OR users.name LIKE '%<keyword>%' OR tags.name LIKE '%<keyword>%')
        // AND users.role_id != 2
        // ORDER BY articles.id ASC
        // LIMIT 10;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = Tag::select('id', 'name')->get();
        // $statuses = ['draft', 'pending']; // Status yang ingin Anda ambil

        // $articles = Article::select('status')
        //     ->whereIn('status', $statuses)
        //     ->get();
        return view('admin.article.article-admin-add', compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleAdminEditRequest $request)
    {
        $newName = NULL;

        if ($request->file('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = 'Admin' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);
        }

        $request['image'] = $newName;
        $user = User::findOrFail($request->author_id);
        $request['slug'] = $user->username . '_' . Str::slug($request->title, '-') . '-' . rand(1000000, 9999999);
        $article = Article::create($request->all());

        return redirect(route('administrator.index'))->with('message', 'Artikel Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = Article::with(['user', 'tags'])
            ->where('slug', $slug)->first();

        if ($article) {
            $clap = ClapArticle::where('article_id', $article->id)->count();
        } else {
            abort(404);
        }
        return view('admin.article.article-admin-detail', compact('article', 'clap'));

        // -- Mendapatkan data artikel berdasarkan slug
        // SELECT articles.*, users.*, tags.*
        // FROM articles
        // JOIN users ON articles.author_id = users.id
        // JOIN tags ON articles.tag_id = tags.id
        // WHERE articles.slug = '<slug>'
        // LIMIT 1;

        // -- Menghitung jumlah clap pada artikel
        // SELECT COUNT(*) AS total_clap
        // FROM clap_articles
        // WHERE article_id = <article_id>;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $article = Article::with(['user', 'tags'])
            ->where('slug', $slug)->first();
        $tag = Tag::where('id', '!=', $article->tag_id)->select('id', 'name')->get();
        return view('admin.article.article-admin-edit', compact('article', 'tag'));

        // -- Mendapatkan data artikel berdasarkan slug
        // SELECT articles.*, users.*, tags.*
        // FROM articles
        // JOIN users ON articles.author_id = users.id
        // JOIN tags ON articles.tag_id = tags.id
        // WHERE articles.slug = '<slug>'
        // LIMIT 1;

        // -- Mendapatkan data tag yang tidak sama dengan tag artikel
        // SELECT id, name
        // FROM tags
        // WHERE id != <tag_id>;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleAdminEditRequest $request, $id)
    {
        // dd($request->all());
        $article = Article::findOrFail($id);

        if ($request->file('photo')) {
            $oldPhotoPath = $article->image; // Path foto lama yang disimpan dalam database

            if ($oldPhotoPath != '') {
                // Hapus foto lama dari sistem file menggunakan Storage::delete()
                Storage::disk('public')->delete('photo/' . $oldPhotoPath);
            }

            // Simpan Foto Baru
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = 'Admin' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);

            $request['image'] = $newName;
        }

        if ($request->title !== $article->title) {
            // Jika nama diubah, perbarui juga slug
            $user = User::findOrFail($request->author_id);
            $request['slug'] = $user->username . '_' . Str::slug($request->title, '-') . '-' . rand(1000000, 9999999);
        }

        $article->update($request->all());

        return redirect(route('administrator.index'))->with('message', 'Perubahan Data Artikel Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return redirect(route('administrator.index'))->with('message', 'Article berhasil dihapus.');
    }
}

// create :
// SELECT id, name FROM tags;

// store :
// INSERT INTO articles (author_id, title, slug, image, content, created_at, updated_at)
// VALUES (:author_id, :title, :slug, :image, :content, :created_at, :updated_at);

// update :
// UPDATE articles
// SET
//     title = :title,
//     slug = :slug,
//     image = :image,
//     content = :content,
//     author_id = :author_id,
//     updated_at = :updated_at
// WHERE id = :id;

// destroy :
// DELETE FROM articles
// WHERE id = :id;