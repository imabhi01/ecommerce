<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author'])
            ->published();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        if ($sort === 'popular') {
            $query->popular();
        } else {
            $query->latest();
        }

        $posts = $query->paginate(9);
        $categories = BlogCategory::where('is_active', true)
            ->withCount('publishedPosts')
            ->get();
        $recentPosts = BlogPost::published()
            ->latest('published_at')
            ->limit(5)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['category', 'author', 'images'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Related posts
        $relatedPosts = BlogPost::with(['category', 'author'])
            ->published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $posts = BlogPost::with(['author'])
            ->published()
            ->where('blog_category_id', $category->id)
            ->latest()
            ->paginate(9);

        $categories = BlogCategory::where('is_active', true)
            ->withCount('publishedPosts')
            ->get();

        return view('blog.category', compact('category', 'posts', 'categories'));
    }
}