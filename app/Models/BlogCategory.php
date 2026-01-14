<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    public function publishedPosts(): HasMany
    {
        // return $this->hasMany(BlogPost::class, 'blog_category_id')
        //     ->where('status', BlogPost::STATUS_PUBLISHED)
        //     ->whereNotNull('published_at')
        //     ->where('published_at', '<=', now());    

        return $this->hasMany(BlogPost::class, 'blog_category_id')
            ->published();
    }
}
