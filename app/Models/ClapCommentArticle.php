<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClapCommentArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_article_id',
    ];

    public function commentArticle()
    {
        return $this->belongsTo(CommentArticle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
