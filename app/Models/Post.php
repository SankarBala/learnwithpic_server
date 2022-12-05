<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
        // return $this->hasMany(Comment::class);
    }
}
