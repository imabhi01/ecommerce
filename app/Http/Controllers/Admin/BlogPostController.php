<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogPostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        if ($request->filled('status')) {
            // Support both 'status' column and 'is_published' column
            if ($request->status === 'published') {
                $query->where(function($q) {
                    // Check if 'status' column exists, otherwise use 'is_published'
                    if (Schema::hasColumn('blog_posts', 'status')) {
                        $q->where('status', 'published');
                    } else {
                        $q->where('is_published', true);
                    }
                });
            } elseif ($request->status === 'draft') {
                $query->where(function($q) {
                    if (Schema::hasColumn('blog_posts', 'status')) {
                        $q->where('status', 'draft');
                    } else {
                        $q->where('is_published', false);
                    }
                });
            }
        }

        $posts = $query->latest()->paginate(15);
        $recentPosts = BlogPost::published()
            ->latest('published_at')
            ->limit(5)
            ->get();
        // $categories = BlogCategory::where('is_active', true)->get();
        $categories = BlogCategory::where('is_active', true)
            ->withCount('publishedPosts')
            ->get();

        return view('admin.blog.posts.index', compact('posts', 'categories', 'recentPosts'));
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->get();
        return view('admin.blog.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:draft,published,scheduled,archived',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_featured_image' => 'nullable|boolean',
        ]);
        // dd($request->all());
        // Set user_id
        $validated['user_id'] = Auth::id();
        
        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (BlogPost::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Handle status based on action button or status field
        if ($request->input('action') === 'draft') {
            $validated['status'] = 'draft';
            $validated['is_published'] = false;
        } elseif ($request->input('action') === 'publish' || $request->input('status') === 'published') {
            $validated['status'] = 'published';
            $validated['is_published'] = true;
            
            // Set published_at if not provided
            if (empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }
        } else {
            // Default to draft if no action specified
            $validated['status'] = $validated['status'] ?? 'draft';
            $validated['is_published'] = $validated['status'] === 'published';
        }

        // Handle boolean fields
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['allow_comments'] = $request->has('allow_comments') ? true : false;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blog/posts/featured', 'public');
        }

        // Create the blog post
        $post = BlogPost::create($validated);

        // Handle additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('blog/posts/gallery', 'public');
                BlogPostImage::create([
                    'blog_post_id' => $post->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                    'alt_text' => $post->title
                ]);
            }
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::where('is_active', true)->get();
        $post->load('images');
        return view('admin.blog.posts.create', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $post->id,
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:draft,published,scheduled,archived',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_featured_image' => 'nullable|boolean',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:blog_post_images,id'
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure unique slug (excluding current post)
            $originalSlug = $validated['slug'];
            $count = 1;
            while (BlogPost::where('slug', $validated['slug'])->where('id', '!=', $post->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Handle status based on action button
        if ($request->input('action') === 'draft') {
            $validated['status'] = 'draft';
            $validated['is_published'] = false;
        } elseif ($request->input('action') === 'publish' || $request->input('status') === 'published') {
            $validated['status'] = 'published';
            $validated['is_published'] = true;
            
            // Set published_at if not already set
            if (empty($post->published_at) && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }
        } else {
            $validated['status'] = $validated['status'] ?? $post->status ?? 'draft';
            $validated['is_published'] = $validated['status'] === 'published';
        }

        // Handle boolean fields
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['allow_comments'] = $request->has('allow_comments') ? true : false;

        // Handle featured image removal
        if ($request->has('remove_featured_image') && $post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blog/posts/featured', 'public');
        }

        // Update the blog post
        $post->update($validated);

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $imageId) {
                $image = BlogPostImage::find($imageId);
                if ($image && $image->blog_post_id === $post->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // Handle new images upload
        if ($request->hasFile('images')) {
            $sortOrder = $post->images()->max('sort_order') ?? 0;
            $sortOrder++;
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('blog/posts/gallery', 'public');
                BlogPostImage::create([
                    'blog_post_id' => $post->id,
                    'image_path' => $path,
                    'sort_order' => $sortOrder++,
                    'alt_text' => $post->title
                ]);
            }
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $post)
    {
        // Delete featured image
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        // Delete additional images
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $post->delete();

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    public function deleteImage($imageId)
    {
        $image = BlogPostImage::findOrFail($imageId);
        
        // Verify the image belongs to a post the user can edit
        $post = $image->post;
        
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }

    // NEW: Image Manager API endpoints for TinyMCE integration
    public function getImages()
    {
        $images = BlogPostImage::latest()
            ->get()
            ->map(function($image) {
                return [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->image_path),
                    'path' => $image->image_path,
                    'alt' => $image->alt_text
                ];
            });

        return response()->json($images);
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $uploaded = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('blog/posts/gallery', 'public');
            
            $blogImage = BlogPostImage::create([
                'image_path' => $path,
                'alt_text' => null,
                'sort_order' => 0
            ]);

            $uploaded[] = [
                'id' => $blogImage->id,
                'url' => asset('storage/' . $path)
            ];
        }

        return response()->json($uploaded);
    }

    public function uploadSingleImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $path = $request->file('image')->store('blog/posts/inline', 'public');
        
        BlogPostImage::create([
            'image_path' => $path,
            'alt_text' => null,
            'sort_order' => 0
        ]);

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }
}