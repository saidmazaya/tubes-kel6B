<?php

// namespace App\Http\Controllers;

// use App\Models\ClapList;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class ClapListController extends Controller
// {
//     public function claplist($article_id)
//     {
//         $claplist = ClapList::where('article_list_id', $article_id)->where('user_id', Auth::user()->id)->first();

//         if ($claplist) {
//             $claplist->delete();

//             return redirect()->back();
//         } else {
//             ClapList::create([
//                 'article_list_id' => $article_id,
//                 'user_id' => Auth::user()->id,
//             ]);

//             return redirect()->back();
//         }
//     }
// }
