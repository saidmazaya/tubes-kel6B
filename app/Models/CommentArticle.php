<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'user_id',
        'article_id',
        'parent_id',
    ];

    public function articles()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(CommentArticle::class, 'parent_id', 'id');
    }

    public function claps()
    {
        return $this->hasMany(ClapCommentArticle::class);
    }
}

//sql query
// SELECT comment_articles.*,
//        users.*
// FROM comment_articles
// LEFT JOIN users ON comment_articles.user_id = users.id;


