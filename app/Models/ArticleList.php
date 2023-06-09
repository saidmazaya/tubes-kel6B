<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'visibility',
        'user_id',
        'add_id',
        'article_id',
        'owner_id',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'id', 'article_id');
    }

    // public function comments()
    // {
    //     return $this->hasMany(CommentList::class, 'article_list_id', 'id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function article_lists()
    {
        return $this->belongsTo(ArticleList::class, 'add_id', 'id');
    }

    public function claps()
    {
        return $this->hasMany(ClapList::class);
    }

    public function bookmarkByUser(User $user, $ownerId, $addId)
    {
        return $this->where('user_id', $user->id)
            ->where('owner_id', $ownerId)
            ->where('add_id', $addId);
    }
}

//query sql

// SELECT article_lists.*,
//        users.*,
//        owners.*,
//        COUNT(articles.id) AS article_count,
//        COUNT(comment_lists.id) AS comment_count,
//        COUNT(clap_lists.id) AS clap_count
// FROM article_lists
// LEFT JOIN users ON article_lists.user_id = users.id
// LEFT JOIN users AS owners ON article_lists.owner_id = owners.id
// LEFT JOIN articles ON article_lists.article_id = articles.id
// LEFT JOIN comment_lists ON article_lists.id = comment_lists.article_list_id
// LEFT JOIN clap_lists ON article_lists.id = clap_lists.article_list_id
// GROUP BY article_lists.id, users.id, owners.id;
