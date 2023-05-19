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
}
