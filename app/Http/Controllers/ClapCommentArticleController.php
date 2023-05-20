<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClapCommentArticle;
use Illuminate\Support\Facades\Auth;

class ClapCommentArticleController extends Controller
{
    public function clap($comment_article_id)
    {
        $clapCommentArticle = ClapCommentArticle::where('comment_article_id', $comment_article_id)->where('user_id', Auth::user()->id)->first();

        if ($clapCommentArticle) {
            $clapCommentArticle->delete();

            return redirect()->back();
        } else {
            ClapCommentArticle::create([
                'comment_article_id' => $comment_article_id,
                'user_id' => Auth::user()->id,
            ]);
            
            return redirect()->back();
        }
    }
}
