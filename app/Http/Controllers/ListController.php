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

        // -- Menghapus artikel dari daftar (bookmark)
        // DELETE FROM article_lists
        // WHERE article_id = <article_id> AND user_id = <user_id> AND add_id = <add_id>;

        // -- Menambahkan artikel ke daftar (bookmark)
        // INSERT INTO article_lists (add_id, name, description, visibility, user_id, article_id, owner_id)
        // VALUES (<add_id>, '<name>', '<description>', '<visibility>', <user_id>, <article_id>, <owner_id>);

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
        $userList = ArticleList::where('user_id', $user->id)
            ->where('owner_id', $user->id)
            ->get();

        if (!$userList) {
            abort(404);
        }

        return view('library', compact('userList'));

        // -- Mengambil data user berdasarkan username
        // SELECT * FROM users WHERE username = '<username>';

        // -- Mengambil semua data article_list yang dimiliki oleh user
        // SELECT * FROM article_lists WHERE user_id = <user_id> AND owner_id = <user_id>;
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

        // -- Mengambil data article_list berdasarkan add_id
        // SELECT * FROM article_lists WHERE add_id = <add_id>;

        // -- Mengubah data article_list
        // UPDATE article_lists SET
        //     name = '<nama_baru>',
        //     description = '<deskripsi_baru>',
        //     visibility = '<visibilitas_baru>'
        // WHERE add_id = <add_id>;

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

        // -- Mengambil data article_list berdasarkan add_id
        // SELECT * FROM article_lists WHERE add_id = <add_id>;

        // -- Menghapus data article_list
        // DELETE FROM article_lists WHERE add_id = <add_id>;
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

        // -- Mengambil data article_list berdasarkan add_id
        // SELECT * FROM article_lists WHERE add_id = <add_id>;

        // -- Menghapus data article_list
        // DELETE FROM article_lists WHERE add_id = <add_id>;
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

        // INSERT INTO article_lists (add_id, name, description, visibility, user_id, article_id, owner_id)
        // SELECT add_id, name, description, visibility, <user_id>, article_id, owner_id
        // FROM article_lists
        // WHERE owner_id = <id> AND add_id = <add_id>;
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

        // DELETE FROM article_lists
        // WHERE owner_id = <id> AND add_id = <add_id> AND user_id = <user_id>;
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

    // SELECT *
    // FROM article_lists
    // WHERE user_id = (SELECT id FROM users WHERE username = '<username>')
    //     AND owner_id != (SELECT id FROM users WHERE username = '<username>')
    //     AND visibility = 'Public';
}
