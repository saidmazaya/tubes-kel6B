<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'image',
        'about',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function commentArticle()
    {
        return $this->hasMany(CommentArticle::class, 'user_id', 'id');
    }

    // public function commentList()
    // {
    //     return $this->hasMany(CommentList::class, 'user_id', 'id');
    // }

    public function list()
    {
        return $this->hasMany(ArticleList::class, 'user_id');
    }

    public function listOwner()
    {
        return $this->hasMany(ArticleList::class, 'owner_id');
    }

    public function claps()
    {
        return $this->hasMany(ClapArticle::class);
    }

    public function clapsComment()
    {
        return $this->hasMany(ClapCommentArticle::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'mutuals', 'user_id', 'following_user_id')->withTimestamps();

        // SELECT users.*
        // FROM users
        // INNER JOIN mutuals ON users.id = mutuals.following_user_id
        // WHERE mutuals.user_id = :user_id;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'mutuals', 'following_user_id', 'user_id')->withTimestamps();

        // SELECT users.*
        // FROM users
        // INNER JOIN mutuals ON users.id = mutuals.user_id
        // WHERE mutuals.following_user_id = :user_id;
    }

    public function follow(User $user)
    {
        return $this->follows()->save($user);

        // INSERT INTO mutuals (user_id, following_user_id, created_at, updated_at)
        // VALUES (:user_id, :following_user_id, NOW(), NOW());
    }

    public function hasFollow(User $user)
    {
        return $this->follows()->where('following_user_id', $user->id)->exists();

        // SELECT EXISTS(
        //     SELECT 1
        //     FROM mutuals
        //     WHERE user_id = :user_id
        //     AND following_user_id = :following_user_id
        // );
    }

    public function unfollow(User $user)
    {
        return $this->follows()->detach($user);

        // DELETE FROM mutuals
        // WHERE user_id = :user_id AND following_user_id = :following_user_id;
    }

    public function followsTag()
    {
        return $this->belongsToMany(Tag::class, 'user_choices', 'user_id', 'tag_id')->withTimestamps();

        //         SELECT tags.*
        // FROM tags
        // INNER JOIN user_choices ON tags.id = user_choices.tag_id
        // WHERE user_choices.user_id = :user_id;
    }

    public function followTag(Tag $tag)
    {
        return $this->followsTag()->save($tag);

        //         INSERT INTO user_choices (user_id, tag_id, created_at, updated_at)
        // VALUES (:user_id, :tag_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
    }

    public function hasFollowTag(Tag $tag)
    {
        return $this->followsTag()->where('tag_id', $tag->id)->exists();

        // SELECT EXISTS(
        //     SELECT 1
        //     FROM user_choices
        //     WHERE user_id = :user_id
        //     AND tag_id = :tag_id
        // );
    }

    public function unfollowTag(Tag $tag)
    {
        return $this->followsTag()->detach($tag);

        //         DELETE FROM user_choices
        // WHERE user_id = :user_id
        // AND tag_id = :tag_id;
    }
}

//query sql

// SELECT users.*,
//        roles.name AS role_name,
//        COUNT(articles.id) AS article_count,
//        COUNT(comment_articles.id) AS comment_article_count,
//        COUNT(comment_lists.id) AS comment_list_count,
//        COUNT(article_lists.id) AS article_list_count,
//        COUNT(clap_articles.id) AS clap_article_count,
//        COUNT(clap_comment_articles.id) AS clap_comment_article_count
// FROM users
// LEFT JOIN roles ON users.role_id = roles.id
// LEFT JOIN articles ON users.id = articles.author_id
// LEFT JOIN comment_articles ON users.id = comment_articles.user_id
// LEFT JOIN article_lists ON users.id = article_lists.user_id
// LEFT JOIN clap_articles ON users.id = clap_articles.user_id
// LEFT JOIN clap_comment_articles ON users.id = clap_comment_articles.user_id
// GROUP BY users.id, roles.name;
