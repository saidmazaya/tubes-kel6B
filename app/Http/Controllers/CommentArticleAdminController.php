<?php

namespace App\Http\Controllers;

use App\Models\CommentArticle;
use Illuminate\Http\Request;

class CommentArticleAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $commentArticle = CommentArticle::with(['articles', 'user'])
            ->where(function ($query) use ($keyword) {
                $query->where('content', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('status', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    })
                    ->orWhereHas('articles', function ($query) use ($keyword) {
                        $query->where('title', 'LIKE', '%' . $keyword . '%');
                    });
            })
            ->whereHas('user', function ($query) {
                $query->where('role_id', '!=', 1);
            })
            ->where('status', '!=', 'Rejected')
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('admin.comment.article.comment-article', compact('commentArticle', 'keyword'));

        // SELECT *
        // FROM comment_articles
        // JOIN users ON comment_articles.user_id = users.id
        // JOIN articles ON comment_articles.article_id = articles.id
        // WHERE (comment_articles.content LIKE '%kata_kunci%'
        //        OR comment_articles.status LIKE '%kata_kunci%'
        //        OR users.name LIKE '%kata_kunci%'
        //        OR articles.title LIKE '%kata_kunci%')
        //   AND users.role_id != 1
        //   AND comment_articles.status != 'Rejected'
        // ORDER BY comment_articles.id ASC
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
    public function show($id)
    {
        $commentArticle = CommentArticle::with(['user', 'articles'])
            ->findOrFail($id);

        if ($commentArticle) {
            return view('admin.comment.article.comment-article-detail', compact('commentArticle'));
        } else {
            abort(404);
        }

        // SELECT *
        // FROM comment_articles
        // JOIN users ON comment_articles.user_id = users.id
        // JOIN articles ON comment_articles.article_id = articles.id
        // WHERE comment_articles.id = id;

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
        $commentArticle = CommentArticle::findOrFail($id);

        $status = $request->status;

        // Pastikan nilai status yang diterima adalah valid
        if ($status == 'Published' || $status == 'Rejected') {
            $commentArticle->status = $status;
            $commentArticle->save();
        }

        // Redirect ke halaman atau tindakan yang sesuai setelah pembaruan status

        return redirect(route('comment.index'))->with('message', 'Status Berhasil Diupdate');

        // UPDATE comment_articles
        // SET status = 'Published' -- atau 'Rejected' tergantung nilai status yang diterima
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
