<?php

namespace App\Http\Controllers;

use App\Models\ArticleList;
use App\Models\yourlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ListController extends Controller
{
    public function toggleyourlist(Request $request)
    {
        $user = $request->user();
        $article = $request->input('article_id');
        $yourListName = $request->input('name');
        $yourListDescription = $request->input('description');

        $existingList = ArticleList::where('name', $yourListName)->first();

        if ($existingList) {
            // List with the same name already exists, use the existing add_id
            $yourListId = $existingList->add_id;
        } else {
            // Generate a new add_id
            $yourListId = ArticleList::max('add_id') + 1;
        }

        if (empty($yourListName)) {
            // Handle jika 'name' kosong, misalnya berikan nilai default atau berikan pesan error.
        } else {
            $yourList = ArticleList::create([
                'add_id' => $yourListId,
                'name' => $yourListName,
                'description' => $yourListDescription,
                'visibility' => 'public',
                'user_id' => $user->id,
                'article_id' => $article,
                'owner_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('message', 'Artikel berhasil ditambahkan ke list');
        }
    }
    
}