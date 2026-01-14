<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status', // Add status
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        // 'is_published' => 'boolean',
        'is_featured' => 'boolean',    // NEW
        'allow_comments' => 'boolean',  // NEW
        'views' => 'integer',
    ];
    
    // Status constants for better code readability
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_ARCHIVED = 'archived';

    // Relationships
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(BlogPostImage::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED)
                    ->where('published_at', '>', now());
    }

    public function scopeArchived($query)
    {
        return $query->where('status', self::STATUS_ARCHIVED);
    }

    // Accessor - Check if post is published
    public function getIsPublishedAttribute()
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    // Helper Methods
    public function isPublished()
    {
        return $this->status === self::STATUS_PUBLISHED 
               && $this->published_at 
               && $this->published_at->lte(now());
    }

    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isScheduled()
    {
        return $this->status === self::STATUS_SCHEDULED 
               && $this->published_at 
               && $this->published_at->gt(now());
    }

    public function isArchived()
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    public function publish()
    {
        $this->update([
            'status' => self::STATUS_PUBLISHED,
            'published_at' => $this->published_at ?? now()
        ]);
    }

    public function archive()
    {
        $this->update(['status' => self::STATUS_ARCHIVED]);
    }

    public function incrementViews(): void
    {
        $key = 'blog_post_viewed_' . $this->id;

        if (!cache()->has($key)) {
            $this->increment('views');
            cache()->put($key, true, now()->addMinutes(30));
        }
    }

    // public function comments()
    // {
    //     return $this->hasMany(BlogComment::class)
    //         ->where('is_approved', true)
    //         ->latest();
    // }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id');
    }
}
