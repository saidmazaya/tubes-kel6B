<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ClapArticle;
use Illuminate\Http\Request;

class ArticleAdminController extends Controller
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
                $query->where('role_id', '!=', 1);

                // AND users.role_id != 1
            })
            ->whereNotIn('status', ['Draft', 'Rejected'])
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('admin.article.article', compact('article', 'keyword'));

        // -- Mengambil data artikel dengan pengguna dan tag terkait yang sesuai dengan kata kunci
        // SELECT articles.*, users.*, tags.*
        // FROM articles
        // JOIN users ON users.id = articles.author_id
        // JOIN tags ON tags.article_id = articles.id
        // WHERE (articles.title LIKE '%' || <keyword> || '%' OR articles.status LIKE '%' || <keyword> || '%' OR users.name LIKE '%' || <keyword> || '%' OR tags.name LIKE '%' || <keyword> || '%')
        //     AND users.role_id != 1
        //     AND articles.status NOT IN ('Draft', 'Rejected')
        // ORDER BY articles.id ASC
        // LIMIT 10;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        return view('admin.article.article-detail', compact('article', 'clap'));

        // -- Mengambil data artikel dengan pengguna dan tag terkait berdasarkan slug
        // SELECT articles.*, users.*, tags.*
        // FROM articles
        // JOIN users ON users.id = articles.author_id
        // JOIN tags ON tags.article_id = articles.id
        // WHERE articles.slug = <slug>;

        // -- Menghitung jumlah tepuk tangan (clap) untuk artikel dengan id yang sesuai
        // SELECT COUNT(*) AS total_clap
        // FROM clap_articles
        // WHERE article_id = <article_id>;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $status = $request->status;

        // Pastikan nilai status yang diterima adalah valid
        if ($status == 'Published' || $status == 'Rejected') {
            $article->status = $status;
            $article->save();
        }

        // Redirect ke halaman atau tindakan yang sesuai setelah pembaruan status

        return redirect(route('article.index'))->with('message', 'Status Berhasil Diupdate');

        // -- Memperbarui status artikel dengan id yang sesuai
        // UPDATE articles
        // SET status = <status>
        // WHERE id = <id>;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


//query sql

// updateStatus :
// UPDATE articles
// SET status = CASE
//     WHEN status = 'Published' OR status = 'Rejected' THEN :status
//     ELSE status
//     END
// WHERE id = :id;