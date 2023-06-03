<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClapList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_list_id',
    ];

    public function articleList()
    {
        return $this->belongsTo(ArticleList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

//sql query
// SELECT clap_lists.*,
//        users.*
// FROM clap_lists
// LEFT JOIN users ON clap_lists.user_id = users.id;
