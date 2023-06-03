<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class YourListController extends Controller
{
    public function yourListShow(Request $request, $id, $username)
    {
        // Mengambil data user yang sedang login
        $user = User::where('username', $username)->first();

        if (!$user) {
            abort(404);
        }

        // Mengambil semua data article_list yang dimiliki oleh user yang sedang login
        $articleLists = ArticleList::where('user_id', $user->id)
            ->where('add_id', $id)
            ->with('article_lists') // Memuat artikel terkait
            ->get();

        if ($articleLists->isEmpty()) {
            abort(404);
        }

        // Mengambil semua article_id dari article_lists yang ditemukan
        $articleIds = $articleLists->pluck('article_id');

        // Mengambil semua detail artikel berdasarkan article_id yang ditemukan
        $articles = Article::whereIn('id', $articleIds)->get();

        $yourList = ArticleList::where('user_id', Auth::user()->id)
            ->where('owner_id', Auth::user()->id)
            ->get();

        return view('yourlist', [
            'user' => $user,
            'articleLists' => $articleLists,
            'articles' => $articles,
            'yourList' => $yourList, // Menambahkan data artikel ke view
        ]);
    }

    // -- Mengambil data user yang sedang login
    // SELECT * FROM users WHERE username = '<username>';

    // -- Mengambil semua data article_list yang dimiliki oleh user yang sedang login
    // SELECT * FROM article_lists WHERE user_id = <user_id> AND add_id = <id>;

    // -- Mengambil semua article_id dari article_lists yang ditemukan
    // SELECT article_id FROM article_lists WHERE user_id = <user_id> AND add_id = <id>;

    // -- Mengambil semua detail artikel berdasarkan article_id yang ditemukan
    // SELECT * FROM articles WHERE id IN (<article_ids>);

    // -- Mengambil semua data artikel yang dimiliki oleh user yang sedang login
    // SELECT * FROM article_lists WHERE user_id = <user_id> AND owner_id = <user_id>;
}
