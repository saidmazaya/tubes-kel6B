<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentArticle;

class CommentArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // dd($request->all());
        $comment = CommentArticle::create($request->all());
        return redirect()->back()->with('message', 'Comment Berhasil di Post');

        // INSERT INTO comment_articles (content, user_id, article_id)
        // VALUES ('<content>', <user_id>, <article_id>);

        // INSERT INTO comment_articles (content, parent_id, status, article_id, user_id)
        // VALUES ('<content>', <parent_id>, 'Published', <article_id>, <user_id>);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $comment = CommentArticle::findOrFail($id);

        if ($comment->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $comment->update($request->all());

        return redirect()->back()->with('message', 'Comment Berhasil di Update');

        // UPDATE comment_articles
        // SET content = '<content>'
        // WHERE id = <id>;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = CommentArticle::findOrFail($id);

        if ($comment->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $comment->delete();

        return redirect()->back()->with('message', 'Comment Berhasil di Hapus');
    }

    // DELETE FROM comment_articles
    // WHERE id = <id>;

}
