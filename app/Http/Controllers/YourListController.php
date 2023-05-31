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
    public function yourListShow(Request $request, $id)
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
    
        // Mengambil semua data article_list yang dimiliki oleh user yang sedang login
        $articleLists = ArticleList::where('user_id', $user->id)
            ->where('add_id', $id)
            ->with('article_lists') // Memuat artikel terkait
            ->get();
    
        // Mengambil semua article_id dari article_lists yang ditemukan
        $articleIds = $articleLists->pluck('article_id');
    
        // Mengambil semua detail artikel berdasarkan article_id yang ditemukan
        $articles = Article::whereIn('id', $articleIds)->get();
    
        return view('yourlist', [
            'user' => $user,
            'articleLists' => $articleLists,
            'articles' => $articles, // Menambahkan data artikel ke view
        ]);
    }
    
} 