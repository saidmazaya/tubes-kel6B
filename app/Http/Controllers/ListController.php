<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArticleList;
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
        $checkAdd = $request->input('add_id');
        $visibility = $request->input('visibility');

        // dd($article);
        $existingList = ArticleList::where('name', $yourListName)->where('user_id', Auth::user()->id)->first();

        if ($existingList) {
            // List with the same name already exists, use the existing add_id
            $yourListId = $existingList->add_id;
        } else {
            // Generate a new add_id
            $yourListId = ArticleList::max('add_id') + 1;
        }

        $bookmark = ArticleList::where('article_id', $article)->where('user_id', Auth::user()->id)->where('add_id', $checkAdd)->first();
        $hasBookmark = !!$bookmark;
        if (empty($yourListName)) {
            // Handle jika 'name' kosong, misalnya berikan nilai default atau berikan pesan error.
        } else {
            if ($hasBookmark) {
                $bookmark->delete();
                return redirect()->back()->with('message', 'Artikel berhasil dihapus dari list');
            } else {
                $yourList = ArticleList::create([
                    'add_id' => $yourListId,
                    'name' => $yourListName,
                    'description' => $yourListDescription,
                    'visibility' => $visibility,
                    'user_id' => $user->id,
                    'article_id' => $article,
                    'owner_id' => Auth::user()->id,
                ]);
                // dd($yourList);
                return redirect()->back()->with('message', 'Artikel berhasil ditambahkan ke list');
            }
        }
    }

    public function showLibrary($username)
    {
        // Mengambil data user berdasarkan username
        $user = User::where('username', $username)->first();

        if (!$user) {
            abort(404);
        }

        if ($user->id != Auth::user()->id) {
            abort(404);
        }

        // Mengambil semua data article_list yang dimiliki oleh user
        $userList = ArticleList::where('user_id', $user->id)->get();

        if (!$userList) {
            abort(404);
        }

        return view('library', compact('userList'));
    }

    public function editList(Request $request, $id)
    {
        $articleLists = ArticleList::where('add_id', $id)->get();
        // dd($articleList);
        if ($articleLists->isEmpty()) {
            // Handle jika data tidak ditemukan
            return redirect()->back()->with('message', 'List tidak ditemukan');
        }

        foreach ($articleLists as $articleList) {
            $articleList->name = $request->input('name');
            $articleList->description = $request->input('description');
            $articleList->visibility = $request->input('visibility');
            $articleList->save();
        }

        return redirect()->back()->with('message', 'List berhasil diupdate');
    }

    public function destroyList($id)
    {
        $articleLists = ArticleList::where('add_id', $id)->get();

        if ($articleLists->isEmpty()) {
            // Handle jika data tidak ditemukan
            return redirect()->back()->with('message', 'List tidak ditemukan');
        }

        foreach ($articleLists as $articleList) {
            $articleList->delete();
        }

        return redirect()->back()->with('message', 'List berhasil dihapus');
    }

    public function destroyListYour($id)
    {
        $articleLists = ArticleList::where('add_id', $id)->get();

        if ($articleLists->isEmpty()) {
            // Handle jika data tidak ditemukan
            return redirect()->back()->with('message', 'List tidak ditemukan');
        }

        foreach ($articleLists as $articleList) {
            $articleList->delete();
        }

        return redirect(route('library', Auth::user()->username))->with('message', 'List berhasil dihapus');
    }

    public function addOtherList(Request $request, $id, $add_id)
    {
        $articleLists = ArticleList::where('owner_id', $id)
            ->where('add_id', $add_id)
            ->get();

        foreach ($articleLists as $articleList) {
            ArticleList::create([
                'add_id' => $articleList->add_id,
                'name' => $articleList->name,
                'description' => $articleList->description,
                'visibility' => $articleList->visibility,
                'user_id' => Auth::user()->id,
                'article_id' => $articleList->article_id,
                'owner_id' => $articleList->owner_id,
            ]);
        }

        return redirect()->back()->with('message', 'Anda berhasil menambah List, Lihat di Saved List');
        // dd($articleLists->toArray());
    }

    public function deleteOtherList(Request $request, $id, $add_id)
    {
        $existingList = ArticleList::where('owner_id', $id)
            ->where('add_id', $add_id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        if ($existingList > 0) {
            return redirect()->back()->with('message', 'Anda berhasil menghapus Saved List');
        }
    }

    public function showLibrarySaved($username)
    {
        // Mengambil data user berdasarkan username
        $user = User::where('username', $username)->first();

        if (!$user) {
            abort(404);
        }

        if ($user->id != Auth::user()->id) {
            abort(404);
        }

        // Mengambil semua data article_list yang dimiliki oleh user dengan user_id yang sama dan owner_id yang berbeda
        $userList = ArticleList::where('user_id', Auth::user()->id)
            ->where('owner_id', '!=', Auth::user()->id)
            ->where('visibility', 'Public')
            ->get();

        // dd($userList->toArray());

        if (!$userList) {
            abort(404);
        }

        return view('saved-list', compact('userList'));
    }
}
