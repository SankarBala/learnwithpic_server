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

    public function getImageAttribute($value){
        return "http://localhost:8000/storage/posts/featured_images/1673871207.png";
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
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



    public function scopeFilter($query, $filters)
    {
        if (isset($filters['status'])) {
            $query->where('status', 'like', '%' . $filters['status'] . '%');
        }

        if (isset($filters['author'])) {
            $query->where('user_id', '=', $filters['author']);
        }

        if (isset($filters['category'])) {
            $query->whereHas('categories', function ($query) use ($filters) {
                $query->where('slug', $filters['category']);
            });
        }

        if (isset($filters['tag'])) {
            $query->whereHas('tags', function ($query) use ($filters) {
                $query->where('slug', $filters['tag']);
            });
        }

        if (isset($filters['month'])) {
            $query->where('created_at', 'like', date("Y-m", strtotime($filters['month'])) . '%');
        }

        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhereHas('steps', function ($query) use ($filters) {
                    $query->where('content', $filters['search']);
                });
        }
    }
}
