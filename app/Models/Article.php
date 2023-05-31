<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'image',
        'duration',
        'author_id',
        'tag_id',
        'status',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function tags()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(CommentArticle::class, 'article_id', 'id')->whereNull('parent_id');
    }

    public function articleList()
    {
        return $this->belongsTo(ArticleList::class, 'article_id', 'id');
    }

    public function claps()
    {
        return $this->hasMany(ClapArticle::class);
    }

    public function bookmarkByUser(User $user, $articleId)
    {
        return $this->hasOne(ArticleList::class)
            ->where('user_id', $user->id)
            ->where('article_id', $articleId);
    }

    public function articleCheckList()
    {
        return $this->hasOne(ArticleList::class, 'article_id', 'id');
    }
    // public function checkArticleInList(Article $articleId, $addId)
    // {
    //     return $this->hasOne(ArticleList::class)
    //         ->where('add_id', $addId)
    //         ->where('article_id', $articleId);
    // }
}
