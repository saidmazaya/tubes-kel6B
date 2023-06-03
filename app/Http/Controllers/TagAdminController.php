<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;

class TagAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $tag = Tag::with('articles')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(10);
        return view('admin.tag.tag', compact('tag', 'keyword'));

        // SELECT *
        // FROM tags
        // INNER JOIN articles ON tags.id = articles.tag_id
        // WHERE tags.name LIKE '%<keyword>%'
        // LIMIT 10;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.tag-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagCreateRequest $request)
    {
        $request['slug'] = Str::slug($request->name, '-');
        $tag = Tag::create($request->all());

        return redirect(route('tag.index'))->with('message', 'Penambahan Data Perhasil');

        // INSERT INTO tags (name, slug, created_at, updated_at)
        // VALUES ('<name>', '<slug>', 'NOW()', 'NOW()');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        return view('admin.tag.tag-edit', compact('tag'));

        // SELECT * FROM tags WHERE slug = '<slug>' LIMIT 1;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagUpdateRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        if ($request->name !== $tag->name) {
            // Jika nama diubah, perbarui juga slug
            $request['slug'] = Str::slug($request->name, '-');
        }

        $tag->update($request->all());

        return redirect(route('tag.index'))->with('message', 'Perubahan Data Tag Berhasil');

        // UPDATE tags SET name = '<name>', slug = '<slug>', updated_at = 'NOW()' WHERE id = '<id>';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        Article::where('tag_id', $tag->id)->update(['tag_id' => null]);

        $tag->delete();

        return redirect(route('tag.index'))->with('message', 'Tag berhasil dihapus.');
    }

    // DELETE FROM tags WHERE id = '<id>';
}
