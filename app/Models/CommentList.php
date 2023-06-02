<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'user_id',
        'article_list_id',
        'parent_id',
    ];

    public function articleList()
    {
        return $this->belongsTo(ArticleList::class, 'article_list_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

//sql query
// SELECT comment_lists.*,
//        users.*
// FROM comment_lists
// LEFT JOIN users ON comment_lists.user_id = users.id;
