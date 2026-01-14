<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogCommentController extends Controller
{
     public function store(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'comment' => 'required|string|max:2000',
            'name'    => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'name'    => auth()->check() ? null : $data['name'] ?? null,
            'email'   => auth()->check() ? null : $data['email'] ?? null,
            'comment' => $data['comment'],
            'is_approved' => false, // moderation
        ]);

        return back()->with('success', 'Comment submitted for review.');
    }
}
