<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ArticleAdminEditRequest;

class ArticleAdminEditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $article = Article::with(['tags', 'user'])
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('status', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    })
                    ->orWhereHas('tags', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    });
            })
            ->whereHas('user', function ($query) {
                $query->where('role_id', '!=', 2);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('admin.article.article-admin', compact('article', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = Tag::select('id', 'name')->get();
        // $statuses = ['draft', 'pending']; // Status yang ingin Anda ambil

        // $articles = Article::select('status')
        //     ->whereIn('status', $statuses)
        //     ->get();
        return view('admin.article.article-admin-add', compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleAdminEditRequest $request)
    {
        $newName = NULL;

        if ($request->file('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = 'Admin' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);
        }

        $request['image'] = $newName;
        $article = Article::create($request->all());

        return redirect(route('administrator.index'))->with('message', 'Artikel Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::with(['user', 'tags'])
            ->findOrFail($id);
        return view('admin.article.article-admin-detail', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::with(['user', 'tags'])
            ->findOrFail($id);
        $tag = Tag::where('id', '!=', $article->tag_id)->select('id', 'name')->get();
        return view('admin.article.article-admin-edit', compact('article', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleAdminEditRequest $request, $id)
    {
        // dd($request->all());
        $article = Article::findOrFail($id);

        if ($request->file('photo')) {
            $oldPhotoPath = $article->image; // Path foto lama yang disimpan dalam database
    
            if ($oldPhotoPath != '') {
                // Hapus foto lama dari sistem file menggunakan Storage::delete()
                Storage::disk('public')->delete('photo/'.$oldPhotoPath);
            }

            // Simpan Foto Baru
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = 'Admin' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);
    
            $request['image'] = $newName;
        }

        $article->update($request->all());

        return redirect(route('administrator.index'))->with('message', 'Perubahan Data Artikel Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return redirect(route('administrator.index'))->with('message', 'Article berhasil dihapus.');
    }
}
