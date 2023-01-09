<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'image'];


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d h:i A');
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post', 'category_id', 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
