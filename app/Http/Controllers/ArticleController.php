<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $article = Article::get();
        return view('article', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = Tag::select('id', 'name')->get();
        return view('main.write', compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $newName = NULL;

        if ($request->file('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = 'Admin' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);
        }

        $request['image'] = $newName;
        $user = User::findOrFail($request->author_id);
        $request['slug'] = $user->username . '_' . Str::slug($request->title, '-') . '-' . rand(1000000, 9999999);
        $article = Article::create($request->all());

        $status = $article->status;

        if ($status == 'Draft') {
            $message = 'Artikel anda masuk ke dalam draft';
        } else if ($status == 'Pending') {
            $message = 'Artikel Anda Berhasil di Publish mohon tunggu persetujuan admin';
        } else {
            $message = 'Status artikel tidak dikenali';
        }

        return redirect('/menuutama')->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = Article::with(['user', 'tags'])
            ->where('slug', $slug)->first();
        return view('article-detail', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        // Memastikan pengguna adalah penulis artikel yang sesuai
        $article = Article::with(['user', 'tags'])
            ->where('slug', $slug)->first();
        $tag = Tag::where('id', '!=', $article->tag_id)->select('id', 'name')->get();
        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        return view('main.write-edit', compact('article', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, $id)
    {
        // dd($request->all());
        $article = Article::findOrFail($id);

        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        if ($request->file('photo')) {
            $oldPhotoPath = $article->image; // Path foto lama yang disimpan dalam database

            if ($oldPhotoPath != '') {
                // Hapus foto lama dari sistem file menggunakan Storage::delete()
                Storage::disk('public')->delete('photo/' . $oldPhotoPath);
            }

            // Simpan Foto Baru
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = 'Admin' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);

            $request['image'] = $newName;
        }

        if ($request->title !== $article->title) {
            // Jika nama diubah, perbarui juga slug
            $user = User::findOrFail($request->author_id);
            $request['slug'] = $user->username . '_' . Str::slug($request->title, '-') . '-' . rand(1000000, 9999999);
        }

        $article->update($request->all());

        return redirect('/menuutama')->with('message', 'Perubahan Data Artikel Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function draft($username)
    {
        $user = User::where('username', $username)->first();
        $users = $user->id;
        $article = Article::with(['user', 'tags'])
            ->where('author_id', $users)
            ->where('status', 'Draft')
            ->get();
        return view('stories-draft', compact('article'));
    }

    public function destroyDraft($id)
    {
        $article = Article::findOrFail($id);

        if ($article->author_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $article->delete();

        return redirect(route('stories.draft', Auth::user()->username))->with('message', 'Draft Article berhasil dihapus.');
    }
}
