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

// -- Menampilkan artikel dengan halaman (pagination)
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
//     articles.status = 'Published'
// ORDER BY
//     articles.id ASC
// LIMIT 10;

// -- Menampilkan semua tag
// SELECT * FROM tags;

// -- Menampilkan semua artikel
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
//     articles.status = 'Published'
// ORDER BY
//     articles.id ASC;
}
