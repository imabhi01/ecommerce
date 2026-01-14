<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'featured' => Blog::where('is_featured', true)
                ->where('is_published', true)
                ->latest('published_at')
                ->first(),

            'latest' => Blog::where('is_published', true)
                ->latest('published_at')
                ->paginate(9),

            'categories' => BlogCategory::where('is_active', true)->get()
        ]);
    }

    public function category($slug)
    {
        $category = BlogCategory::whereSlug($slug)->firstOrFail();

        return view('blog.category', [
            'category' => $category,
            'blogs' => $category->blogs()
                ->where('is_published', true)
                ->latest()
                ->paginate(9)
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::whereSlug($slug)
            ->where('is_published', true)
            ->firstOrFail();

        $blog->increment('views');

        return view('blog.show', compact('blog'));
    }
}
