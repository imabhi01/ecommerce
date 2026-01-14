@extends('layouts.admin')

@section('page-title', 'Edit Blog Post')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Edit Blog Post</h2>

    <form action="{{ route('admin.blog.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Category</label>
            <select name="blog_category_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('blog_category_id', $post->blog_category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('blog_category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Excerpt -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Excerpt</label>
            <textarea name="excerpt" rows="3" required
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Content -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Content</label>
            <textarea name="content" rows="6" required
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('content', $post->content) }}</textarea>
            @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Featured Image -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Featured Image</label>
            @if($post->featured_image)
                <img src="{{ asset('storage/'.$post->featured_image) }}" class="w-48 h-32 object-cover mb-2 rounded">
            @endif
            <input type="file" name="featured_image" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('featured_image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Additional Images -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Additional Images</label>
            <div class="flex flex-wrap gap-2 mb-2">
                @foreach($post->images as $image)
                    <div class="relative">
                        <img src="{{ asset('storage/'.$image->image_path) }}" class="w-24 h-24 object-cover rounded">
                        <a href="{{ route('admin.blog.posts.deleteImage', $image->id) }}" class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700">×</a>
                    </div>
                @endforeach
            </div>
            <input type="file" name="images[]" multiple class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('images.*') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Meta -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Meta Description</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $post->meta_description) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Publish -->
        <div class="flex items-center space-x-3">
            <input type="checkbox" name="is_published" id="is_published" class="w-4 h-4 text-indigo-600 border-gray-300 rounded" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
            <label for="is_published" class="text-gray-700 font-medium">Publish</label>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-medium transition-colors">
                Update Post
            </button>
            <a href="{{ route('admin.blog.posts.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
