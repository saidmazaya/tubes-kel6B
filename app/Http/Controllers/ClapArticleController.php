<?php

namespace App\Http\Controllers;

use App\Models\ClapArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClapArticleController extends Controller
{
    public function clap($article_id)
    {
        $clap = ClapArticle::where('article_id', $article_id)->where('user_id', Auth::user()->id)->first();

        if ($clap) {
            $clap->delete();

            return redirect()->back();
        } else {
            ClapArticle::create([
                'article_id' => $article_id,
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back();
        }
    }

    // -- Memeriksa apakah pengguna sudah memberikan clap pada artikel
    // SELECT * FROM clap_articles WHERE article_id = 'id_artikel' AND user_id = 'id_pengguna';

    // -- Menghapus clap pengguna pada artikel
    // DELETE FROM clap_articles WHERE article_id = 'id_artikel' AND user_id = 'id_pengguna';

    // -- Menambah clap pengguna pada artikel
    // INSERT INTO clap_articles (article_id, user_id) VALUES ('id_artikel', 'id_pengguna');

}
