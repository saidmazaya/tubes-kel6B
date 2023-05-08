<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function tags()
    {
        return $this->hasMany(Tag::class, 'id', 'tag_id');
    }
}
