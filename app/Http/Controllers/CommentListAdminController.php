<?php

// namespace App\Http\Controllers;

// use App\Models\CommentList;
// use Illuminate\Http\Request;

// class CommentListAdminController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index(Request $request)
//     {
//         $keyword = $request->keyword;
//         $commentList = CommentList::with(['articleList', 'user'])
//             ->where(function ($query) use ($keyword) {
//                 $query->where('content', 'LIKE', '%' . $keyword . '%')
//                     ->orWhere('status', 'LIKE', '%' . $keyword . '%')
//                     ->orWhereHas('user', function ($query) use ($keyword) {
//                         $query->where('name', 'LIKE', '%' . $keyword . '%');
//                     })
//                     ->orWhereHas('articleList', function ($query) use ($keyword) {
//                         $query->where('name', 'LIKE', '%' . $keyword . '%');
//                     });
//             })
//             ->whereHas('user', function ($query) {
//                 $query->where('role_id', '!=', 1);
//             })
//             ->where('status', '!=', 'Rejected')
//             ->orderBy('id', 'asc')
//             ->paginate(10);
//         return view('admin.comment.list.comment-list', compact('commentList', 'keyword'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show($id)
//     {
//         $commentList = CommentList::with(['user', 'articleList'])
//             ->findOrFail($id);

//         if ($commentList) {
//             return view('admin.comment.list.comment-list-detail', compact('commentList'));
//         } else {
//             abort(404);
//         }
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     public function updateStatus(Request $request, $id)
//     {
//         $commentList = CommentList::findOrFail($id);

//         $status = $request->status;

//         // Pastikan nilai status yang diterima adalah valid
//         if ($status == 'Published' || $status == 'Rejected') {
//             $commentList->status = $status;
//             $commentList->save();
//         }

//         // Redirect ke halaman atau tindakan yang sesuai setelah pembaruan status

//         return redirect(route('list.index'))->with('message', 'Status Berhasil Diupdate');
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
