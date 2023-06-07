<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function show($slug)
    {
        $tagCheck = Tag::where('slug', $slug)->first();

        if ($tagCheck) {
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
                ->where('status', 'Published')
                ->distinct('author_id')
                ->count('author_id');

            return view('tag-detail', compact('article', 'tag', 'articleCount', 'authorCount', 'tagCheck'));
        } else {
            abort(404);
        }

        // SELECT articles.*
        // FROM articles
        // INNER JOIN tags ON articles.tag_id = tags.id
        // WHERE tags.slug = '<slug>' AND articles.status = 'Published'
        // LIMIT 10;

        // authorCount
        // SELECT COUNT(DISTINCT author_id) AS authorCount
        // FROM articles
        // INNER JOIN tags ON articles.tag_id = tags.id
        // WHERE tags.slug = '<slug>' AND articles.status = 'Published';

        // articleCount
        // SELECT COUNT(*) AS articleCount
        // FROM articles
        // INNER JOIN tags ON articles.tag_id = tags.id
        // WHERE tags.slug = '<slug>' AND articles.status = 'Published';
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

        // SELECT *
        // FROM tags
        // WHERE name LIKE '%<keyword>%';
    }

    public function store(Request $request, Tag $tag)
    {

        if ($tag) {
            Auth::user()->hasFollowTag($tag) ? Auth::user()->unfollowTag($tag) : Auth::user()->followTag($tag);

            return back();
        } else {
            abort(404);
        }
    }

    // INSERT INTO user_choices (user_id, tag_id) VALUES (<user_id>, <tag_id>);

    // DELETE FROM user_choices WHERE user_id = <user_id> AND tag_id = <tag_id>;
}
