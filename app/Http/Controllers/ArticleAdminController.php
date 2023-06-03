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
            })
            ->whereNotIn('status', ['Draft', 'Rejected'])
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('admin.article.article', compact('article', 'keyword'));
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

// index :
// SELECT *
// FROM articles
// JOIN users ON articles.user_id = users.id
// JOIN article_tag ON articles.id = article_tag.article_id
// JOIN tags ON article_tag.tag_id = tags.id
// WHERE (articles.title LIKE '%keyword%' OR articles.status LIKE '%keyword%' OR users.name LIKE '%keyword%' OR tags.name LIKE '%keyword%')
// AND users.role_id != 1
// AND articles.status NOT IN ('Draft', 'Rejected')
// ORDER BY articles.id ASC
// LIMIT 10 OFFSET x

// show :
// SELECT articles., users., tags.*, COUNT(clap_articles.id) AS clap
// FROM articles
// JOIN users ON articles.user_id = users.id
// JOIN article_tag ON articles.id = article_tag.article_id
// JOIN tags ON article_tag.tag_id = tags.id
// LEFT JOIN clap_articles ON articles.id = clap_articles.article_id
// WHERE articles.slug = 'slug'
// GROUP BY articles.id, users.id, tags.id

// updateStatus :
// UPDATE articles
// SET status = CASE
//     WHEN status = 'Published' OR status = 'Rejected' THEN :status
//     ELSE status
//     END
// WHERE id = :id;