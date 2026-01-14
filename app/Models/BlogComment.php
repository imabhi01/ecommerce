<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_post_id',
        'user_id',
        'name',
        'email',
        'comment',
        'is_approved',
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
