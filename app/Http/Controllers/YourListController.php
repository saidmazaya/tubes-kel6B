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
}
