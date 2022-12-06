<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function parents()
    {
        return $this->belongsToMany(Category::class, 'category_family', 'child_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(Category::class, 'category_family', 'parent_id', 'child_id');
    }
}
