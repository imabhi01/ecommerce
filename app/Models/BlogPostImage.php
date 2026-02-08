<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPostImage extends Model
{
    protected $fillable = [
        'blog_post_id',
        'image_path',
        'sort_order',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }



    // NEW CLAUDE CODE CHUNK BEGINS


    // ─── Scopes ───────────────────────────────────────────────────

    /**
     * Images that are NOT attached to any post yet.
     * These are the "free" images sitting in the photo library.
     */
    public function scopeLibrary($query)
    {
        return $query->whereNull('blog_post_id');
    }

    /**
     * All images: both library images and images attached to posts.
     * Useful for the "browse all" view in the photo library modal.
     */
    public function scopeAll($query)
    {
        // no filter — returns everything, but exists so the intent is explicit
        return $query;
    }

    // ─── Helpers ──────────────────────────────────────────────────

    /**
     * Returns the public URL for this image.
     */
    public function getUrl(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Attach this image to a blog post.
     */
    public function attachTo(int $postId): void
    {
        $this->update(['blog_post_id' => $postId]);
    }

    /**
     * Detach this image from its post (moves it back to the library).
     */
    public function detachFromPost(): void
    {
        $this->update(['blog_post_id' => null]);
    }
}
