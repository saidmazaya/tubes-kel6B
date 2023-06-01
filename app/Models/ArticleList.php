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

    public function comments()
    {
        return $this->hasMany(CommentList::class, 'article_list_id', 'id');
    }

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
