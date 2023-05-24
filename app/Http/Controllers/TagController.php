<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug)
    {
        $article = Article::whereHas('tags', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })
        ->where('status', 'Published')
        ->paginate(10);

        $tag = Tag::all();

        $articleCount = Article::whereHas('tags', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })
        ->where('status', 'Published')
        ->count();

        $authorCount = Article::whereHas('tags', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })
        ->where('status', 'published')
        ->distinct('author_id')
        ->count('author_id');
        
        return view('tag-detail', compact('article', 'tag', 'articleCount', 'authorCount'));
    }

    public function explore(Request $request)
    {
        $keyword = $request->keyword;
        $tag = Tag::with('articles')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->get();

        return view('tag-explore', compact('tag', 'keyword'));
    }
}
