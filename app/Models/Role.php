<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}

//sql query
// SELECT roles.*,
//        COUNT(users.id) AS user_count
// FROM roles
// LEFT JOIN users ON roles.id = users.role_id
// GROUP BY roles.id;
