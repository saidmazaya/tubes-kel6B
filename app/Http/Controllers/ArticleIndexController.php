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
}
