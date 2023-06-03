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
            ->where('owner_id', $user->id)
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


//query sql

// SELECT articles.*,
//        users.*,
//        tags.*,
//        COUNT(comment_articles.id) AS comment_count,
//        COUNT(clap_articles.id) AS clap_count,
//        article_lists.id AS bookmark_id
// FROM articles
// LEFT JOIN users ON articles.author_id = users.id
// LEFT JOIN tags ON articles.tag_id = tags.id
// LEFT JOIN comment_articles ON articles.id = comment_articles.article_id AND comment_articles.parent_id IS NULL
// LEFT JOIN clap_articles ON articles.id = clap_articles.article_id
// LEFT JOIN article_lists ON articles.id = article_lists.article_id
// GROUP BY articles.id, users.id, tags.id, article_lists.id;
