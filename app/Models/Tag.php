<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'tag_id', 'id');
    }
}

//sql query
// SELECT tags.*,
//        COUNT(articles.id) AS article_count
// FROM tags
// LEFT JOIN articles ON tags.id = articles.tag_id
// GROUP BY tags.id;

