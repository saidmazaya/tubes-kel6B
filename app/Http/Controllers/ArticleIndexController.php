<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleIndexController extends Controller
{
    public function tampilanAwal()
    {
        $article = Article::with(['tags', 'user'])
            ->where('status', 'Published')
            ->orderBy('id', 'asc')
            ->paginate(10);
        $tag = Tag::all();
        $articles = Article::with(['tags', 'user'])
            ->where('status', 'Published')
            ->orderBy('id', 'asc')
            ->get();
        return view('index', compact('article', 'tag', 'articles'));
    }

    // -- Mengambil data artikel dengan tag dan pengguna terkait
    // SELECT * FROM articles
    // JOIN tags ON tags.article_id = articles.id
    // JOIN users ON users.id = articles.author_id
    // WHERE articles.status = 'Published'
    // ORDER BY articles.id ASC
    // LIMIT 10;

    // -- Mengambil semua data tag
    // SELECT * FROM tags;

    // -- Mengambil semua data artikel dengan tag dan pengguna terkait
    // SELECT * FROM articles
    // JOIN tags ON tags.article_id = articles.id
    // JOIN users ON users.id = articles.author_id
    // WHERE articles.status = 'Published'
    // ORDER BY articles.id ASC;

}
