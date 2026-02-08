@extends('layouts.admin')

@section('page-title', isset($post) ? 'Edit Blog Post' : 'Create Blog Post')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
@endpush

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog.posts.index') }}" 
       class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Blog Posts
    </a>
    <h2 class="text-2xl font-bold text-gray-800">{{ isset($post) ? 'Edit Blog Post' : 'Create New Blog Post' }}</h2>
</div>

{{-- Global Validation Errors Alert --}}
@if ($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                    There {{ $errors->count() > 1 ? 'were' : 'was' }} {{ $errors->count() }} error{{ $errors->count() > 1 ? 's' : '' }} with your submission
                </h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<form action="{{ isset($post) ? route('admin.blog.posts.update', $post) : route('admin.blog.posts.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      id="blogPostForm">
    @csrf
    @if(isset($post))
        @method('PUT')
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Post Content</h3>
                
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="postTitle"
                               value="{{ old('title', $post->title ?? '') }}"
                               required
                               placeholder="Enter an engaging title for your blog post"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                        <input type="text" 
                               name="slug" 
                               id="postSlug"
                               value="{{ old('slug', $post->slug ?? '') }}"
                               placeholder="auto-generated-from-title"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('slug') border-red-500 bg-red-50 @else border-gray-300 bg-gray-50 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Leave empty to auto-generate from title</p>
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Excerpt — now a rich editor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-500 mb-2">
                            Rich description shown on listing pages. Supports formatting and inline code.
                        </p>
                        <!-- TinyMCE will replace this textarea -->
                        <textarea id="excerpt"
                                  name="excerpt"
                                  class="w-full @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                        @error('excerpt')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Content (TinyMCE — full toolbar) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  class="w-full @error('content') border-red-500 @enderror">{{ old('content', $post->content ?? '') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Featured Image</h3>
                
                <div>
                    @if(isset($post) && $post->featured_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 class="w-full h-64 object-cover rounded-lg border @error('featured_image') border-red-500 @else border-gray-200 @enderror">
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="remove_featured_image" value="1" class="mr-2 rounded">
                                <span class="text-sm text-gray-600">Remove current image</span>
                            </label>
                        </div>
                    @endif
                    
                    <div class="flex gap-3 items-center">
                        <input type="file" 
                               name="featured_image" 
                               id="featuredFileInput"
                               accept="image/*"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('featured_image') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                        <button type="button" id="btnOpenLibraryFeatured"
                                class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition text-sm font-medium whitespace-nowrap">
                            📷 From Library
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Upload new or pick from your photo library. Recommended: 1200×630px (Max: 5MB)</p>
                    @error('featured_image')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    
                    <div id="featuredPreview" class="mt-4 hidden">
                        <img id="featuredImg" class="w-full h-64 object-cover rounded-lg">
                    </div>

                    <!-- Hidden: stores the library image path when picked from the modal -->
                    <input type="hidden" name="featured_image_from_library" id="featuredImageFromLibrary" value="">
                </div>
            </div>

            <!-- Additional Images -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Additional Images</h3>
                
                <div>
                    <div class="flex gap-3 items-center">
                        <input type="file" 
                               name="images[]" 
                               id="galleryFileInput"
                               multiple
                               accept="image/*"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('images.*') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                        <button type="button" id="btnOpenLibraryGallery"
                                class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition text-sm font-medium whitespace-nowrap">
                            📷 From Library
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Upload new or pick from your photo library (Max: 5MB each)</p>
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    
                    <!-- Existing images (edit mode) -->
                    @if(isset($post) && $post->images->isNotEmpty())
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            @foreach($post->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                                    <label class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-1 rounded cursor-pointer transition">
                                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="hidden">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Preview of newly selected files -->
                    <div id="imagesPreview" class="grid grid-cols-3 gap-4 mt-4"></div>

                    <!-- Hidden: stores IDs of images picked from the library for gallery -->
                    <input type="hidden" name="gallery_images_from_library" id="galleryImagesFromLibrary" value="">
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">SEO Settings</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" 
                               name="meta_title" 
                               value="{{ old('meta_title', $post->meta_title ?? '') }}"
                               maxlength="255"
                               placeholder="SEO optimized title (leave empty to use post title)"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('meta_title') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Recommended: 50-60 characters</p>
                        @error('meta_title')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" 
                                  rows="3"
                                  maxlength="500"
                                  placeholder="SEO meta description"
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('meta_description') border-red-500 bg-red-50 @else border-gray-300 @enderror">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Recommended: 150-160 characters</p>
                        @error('meta_description')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" 
                               name="meta_keywords" 
                               value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
                               placeholder="keyword1, keyword2, keyword3"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('meta_keywords') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Separate keywords with commas</p>
                        @error('meta_keywords')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Publish Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Publish</h3>
                
                <div class="space-y-4">
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('status') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                            <option value="draft" {{ old('status', $post->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ old('status', $post->status ?? '') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="archived" {{ old('status', $post->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Published Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                        <input type="datetime-local" 
                               name="published_at" 
                               value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('published_at') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Leave empty for immediate publish</p>
                        @error('published_at')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="blog_category_id" 
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('blog_category_id') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('blog_category_id', $post->blog_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('blog_category_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Featured Post -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}
                                   class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Featured Post</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Show this post on homepage</p>
                    </div>

                    <!-- Allow Comments -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="allow_comments" 
                                   value="1"
                                   {{ old('allow_comments', $post->allow_comments ?? true) ? 'checked' : '' }}
                                   class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Allow Comments</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    <button type="submit" 
                            name="action" 
                            value="publish"
                            class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                        {{ isset($post) ? 'Update Post' : 'Publish Post' }}
                    </button>
                    
                    <button type="submit" 
                            name="action" 
                            value="draft"
                            class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition font-medium">
                        Save as Draft
                    </button>
                    
                    <a href="{{ route('admin.blog.posts.index') }}" 
                       class="block w-full text-center bg-white text-gray-700 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition font-medium">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Post Info (Edit Mode Only) -->
            @if(isset($post))
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Post Info</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-600">Created:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ $post->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Views:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ number_format($post->views ?? 0) }}</span>
                        </div>
                        @if(isset($post->comments))
                        <div>
                            <span class="text-gray-600">Comments:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ $post->comments->count() }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Tips -->
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3 text-blue-900">📝 Writing Tips</h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>• Use engaging headlines</li>
                    <li>• Break content into sections</li>
                    <li>• Add relevant images</li>
                    <li>• Use the <strong>code</strong> button in the editor for code snippets</li>
                    <li>• Optimize for SEO</li>
                    <li>• Proofread before publishing</li>
                </ul>
            </div>
        </div>
    </div>
</form>

<!-- ═══════════════════════════════════════════════════════════════════════════
     PHOTO LIBRARY MODAL
     ═══════════════════════════════════════════════════════════════════════════ -->
<div id="photoLibraryModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">

        <!-- Modal Header -->
        <div class="flex items-center justify-between p-5 border-b bg-gray-50">
            <div>
                <h3 class="text-xl font-bold text-gray-800">📷 Photo Library</h3>
                <p class="text-sm text-gray-500" id="libraryModalSubtitle">Select an image</p>
            </div>
            <button id="btnCloseLibrary" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Upload Bar -->
        <div class="p-4 border-b bg-gray-50 flex items-center gap-3 flex-wrap">
            <input type="file" id="libraryUploadInput" accept="image/*" multiple class="hidden">
            <button id="btnTriggerUpload"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Upload New
            </button>
            <span id="libraryUploadStatus" class="text-sm text-gray-500">No files selected</span>
            <div class="ml-auto">
                <input type="text" id="librarySearchInput" placeholder="Search images..." 
                       class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48">
            </div>
        </div>

        <!-- Image Grid (scrollable) -->
        <div class="flex-1 overflow-y-auto p-4">
            <div id="libraryGrid" class="grid grid-cols-4 gap-3">
                <!-- populated by JS -->
            </div>
            <!-- Loading / empty state -->
            <div id="libraryEmptyState" class="hidden text-center text-gray-400 py-12 text-sm">
                No images found.
            </div>
            <div id="libraryLoadingState" class="text-center text-gray-400 py-8 text-sm">
                Loading…
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between p-4 border-t bg-gray-50 text-sm text-gray-600">
            <span id="libraryPaginationInfo">Showing 0 images</span>
            <div class="flex gap-2">
                <button id="libraryPrevBtn"
                        class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed" disabled>
                    ← Prev
                </button>
                <button id="libraryNextBtn"
                        class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed" disabled>
                    Next →
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alt-text edit mini-modal (appears when you click the pencil on an image) -->
<div id="altEditModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm">
        <h4 class="font-bold text-gray-800 mb-3">Edit Alt Text</h4>
        <input type="hidden" id="altEditImageId" value="">
        <input type="text" id="altEditInput" placeholder="Describe the image…"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">
        <div class="flex justify-end gap-2">
            <button id="btnCancelAltEdit" class="px-4 py-1.5 text-sm text-gray-600 border border-gray-300 rounded hover:bg-gray-50">Cancel</button>
            <button id="btnSaveAltEdit" class="px-4 py-1.5 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* ── Inline code ── */
    .blog-content code,
    .blog-excerpt code,
    .tox-tinymce .tox-edit-area iframe * code   /* inside TinyMCE iframes */
    {
        background-color: #f1f5f9;
        color: #e11d48;
        font-family: 'SF Mono', 'Fira Code', 'Fira Mono', 'Roboto Mono', monospace;
        font-size: 0.875em;
        padding: 0.15em 0.4em;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }

    /* ── Fenced code blocks ── */
    .blog-content pre,
    .blog-excerpt pre
    {
        background-color: #1e1e2e;          /* dark background */
        color: #cdd6f4;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        overflow-x: auto;
        margin: 1rem 0;
        border: 1px solid #313244;
        position: relative;
    }

    .blog-content pre code,
    .blog-excerpt pre code
    {
        /* reset the inline-code styles when inside a <pre> */
        background: none;
        border: none;
        color: inherit;
        padding: 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* ── TinyMCE source-code modal (the <> button opens this) ── */
    .tox-modal .tox-modal__wrap {
        min-width: 700px !important;
    }

    /* ── Photo library card selection ring ── */
    .library-card.selected {
        ring: 2px solid #4f46e5;
        outline: 3px solid #4f46e5;
        outline-offset: -3px;
    }

    /* ── Delete button on library cards ── */
    .library-card:hover .library-card-delete {
        opacity: 100;
    }
    .library-card-delete {
        opacity: 0;
        transition: opacity 0.15s;
    }
</style>
@endpush
@push('scripts')
<!-- TinyMCE - Community Edition (no API key required) -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>

<script>
// ─────────────────────────────────────────────────────────────────────────────
// SHARED: code-block styles injected into TinyMCE iframes
// ─────────────────────────────────────────────────────────────────────────────
const CODE_STYLES = `
    code {
        background-color:#f1f5f9; color:#e11d48;
        font-family:'SF Mono','Fira Code',monospace;
        font-size:0.875em; padding:0.15em 0.4em;
        border-radius:4px; border:1px solid #e2e8f0;
    }
    pre {
        background-color:#1e1e2e; color:#cdd6f4;
        border-radius:8px; padding:1rem 1.25rem;
        overflow-x:auto; border:1px solid #313244;
    }
    pre code { background:none; border:none; color:inherit; padding:0; }
`;

// ─────────────────────────────────────────────────────────────────────────────
// TINYMCE — shared config factory
// ─────────────────────────────────────────────────────────────────────────────
function getTinyMCEConfig(selector, { height = 600, toolbar = null, menubar = true } = {}) {
    return {
        selector,
        height,
        menubar,
        plugins: [
            'advlist','autolink','lists','link','image','charmap','preview',
            'anchor','searchreplace','visualblocks',
            'code','codesample','fullscreen',
            'insertdatetime','media','table','help','wordcount'
        ],
        toolbar: toolbar || ' undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright | bullist numlist outdent indent | codesample code | image media link | fullscreen help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px } ' + CODE_STYLES,
        file_picker_types: 'image',
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype === 'image') {
                openPhotoLibrary('tinymce', callback);
            }
        },
        // PROMISE-BASED (TinyMCE 6 compliant)
        images_upload_handler: function (blobInfo) {
            return uploadImageViaTinyMCE(blobInfo);
        },
        codesample_languages: [
            { text: 'PHP', value: 'php' },
            { text: 'Python', value: 'python' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'HTML', value: 'markup' },
            { text: 'CSS', value: 'css' },
            { text: 'Bash', value: 'bash' },
            { text: 'SQL', value: 'sql' },
            { text: 'JSON', value: 'json' }
        ],
        paste_data_images: true,
        paste_as_text: false,  // Keeps formatting from Word
    };
}

// ─────────────────────────────────────────────────────────────────────────────
// Wait for TinyMCE to load before initializing
// ─────────────────────────────────────────────────────────────────────────────
function initTinyMCE() {
    if (typeof tinymce === 'undefined') {
        console.error('TinyMCE failed to load');
        return;
    }

    console.log('Initializing TinyMCE...');

    // INIT: Content editor (full toolbar)
    tinymce.init(getTinyMCEConfig('#content', { height: 600 }));

    // INIT: Excerpt / Description editor (trimmed toolbar, shorter height)
    tinymce.init(getTinyMCEConfig('#excerpt', {
        height: 300,
        menubar: false,
        toolbar: 'bold italic | bullist numlist | link | code | removeformat'
    }));

    console.log('TinyMCE initialization complete');
}

// Initialize TinyMCE when script loads
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTinyMCE);
} else {
    initTinyMCE();
}

// ─────────────────────────────────────────────────────────────────────────────
// FORM SUBMIT: Sync TinyMCE content back to textareas BEFORE validation
// ─────────────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('blogPostForm');
    
    form?.addEventListener('submit', function(e) {
        console.log('Form submitting, syncing TinyMCE...');
        
        // Sync all TinyMCE editors
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave(); // Global save all editors
            
            // Also manually sync each editor to be absolutely sure
            tinymce.editors.forEach(editor => {
                editor.save();
                console.log('Synced editor:', editor.id);
            });
            
            // Check if excerpt has content now
            const excerptValue = document.getElementById('excerpt').value;
            console.log('Excerpt value after sync:', excerptValue ? 'HAS CONTENT' : 'EMPTY');
            
            if (!excerptValue) {
                e.preventDefault();
                alert('Please fill in the Description field');
                return false;
            }
        }
    });
});

// ═════════════════════════════════════════════════════════════════════════════
// DOM EVENT LISTENERS — bind all buttons after DOM is ready
// ═════════════════════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Content Loaded - binding event listeners...');
    
    // Featured image preview
    const featuredInput = document.getElementById('featuredFileInput');
    console.log('featuredFileInput found:', !!featuredInput);
    featuredInput?.addEventListener('change', function(e) {
        previewImage(e);
    });

    // Gallery images preview
    const galleryInput = document.getElementById('galleryFileInput');
    console.log('galleryFileInput found:', !!galleryInput);
    galleryInput?.addEventListener('change', function(e) {
        previewMultipleImages(e);
    });

    // "From Library" buttons
    const btnFeatured = document.getElementById('btnOpenLibraryFeatured');
    console.log('btnOpenLibraryFeatured found:', !!btnFeatured);
    btnFeatured?.addEventListener('click', function () {
        console.log('Featured library button clicked');
        openPhotoLibrary('featured');
    });

    const btnGallery = document.getElementById('btnOpenLibraryGallery');
    console.log('btnOpenLibraryGallery found:', !!btnGallery);
    btnGallery?.addEventListener('click', function () {
        console.log('Gallery library button clicked');
        openPhotoLibrary('gallery');
    });

    // Photo library modal close button
    document.getElementById('btnCloseLibrary')?.addEventListener('click', function () {
        closePhotoLibrary();
    });

    // Photo library upload trigger
    document.getElementById('btnTriggerUpload')?.addEventListener('click', function () {
        document.getElementById('libraryUploadInput').click();
    });

    // Photo library search
    document.getElementById('librarySearchInput')?.addEventListener('input', function(e) {
        searchLibrary(e.target.value);
    });

    // Photo library pagination
    document.getElementById('libraryPrevBtn')?.addEventListener('click', function () {
        loadLibraryPage(libraryState.currentPage - 1);
    });

    document.getElementById('libraryNextBtn')?.addEventListener('click', function () {
        loadLibraryPage(libraryState.currentPage + 1);
    });

    // Alt edit modal buttons
    document.getElementById('btnCancelAltEdit')?.addEventListener('click', function () {
        closeAltEdit();
    });

    document.getElementById('btnSaveAltEdit')?.addEventListener('click', function () {
        saveAltEdit();
    });
    
    console.log('All event listeners bound successfully');
});


// ─────────────────────────────────────────────────────────────────────────────
// SLUG: auto-generate from title (only while slug hasn't been manually edited)
// ─────────────────────────────────────────────────────────────────────────────
let slugManuallyEdited = document.getElementById('postSlug').value !== '';

document.getElementById('postTitle').addEventListener('input', function(e) {
    if (slugManuallyEdited) return;
    document.getElementById('postSlug').value = e.target.value
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
});
document.getElementById('postSlug').addEventListener('input', () => { slugManuallyEdited = true; });

// ─────────────────────────────────────────────────────────────────────────────
// FEATURED IMAGE: local file preview
// ─────────────────────────────────────────────────────────────────────────────
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('featuredPreview').classList.remove('hidden');
        document.getElementById('featuredImg').src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// ─────────────────────────────────────────────────────────────────────────────
// ADDITIONAL IMAGES: local file preview
// ─────────────────────────────────────────────────────────────────────────────
function previewMultipleImages(event) {
    const files   = event.target.files;
    const preview = document.getElementById('imagesPreview');
    preview.innerHTML = '';
    for (const file of files) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border border-gray-200">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// TinyMCE inline-image upload (drag & drop or paste in the editor)
// ─────────────────────────────────────────────────────────────────────────────
function uploadImageViaTinyMCE(blobInfo) {
    return new Promise(function (resolve, reject) {
        var formData = new FormData();
        formData.append('image', blobInfo.blob(), blobInfo.filename());

        fetch('/admin/blog/photo-library/upload-single', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(function (response) {
            if (!response.ok) {
                reject('HTTP Error: ' + response.status);
                return;
            }
            return response.json();
        })
        .then(function (data) {
            if (!data || !data.url) {
                reject('Invalid server response');
                return;
            }
            resolve(data.url); // ✅ TinyMCE inserts this URL
        })
        .catch(function (error) {
            reject('Upload failed: ' + error);
        });
    });
}


// ═════════════════════════════════════════════════════════════════════════════
// PHOTO LIBRARY MODAL
// ═════════════════════════════════════════════════════════════════════════════

// Internal state — tracks what the modal is doing and who opened it.
const libraryState = {
    mode: 'featured',        // 'featured' | 'gallery' | 'tinymce'
    currentPage: 1,
    totalPages: 1,
    totalItems: 0,
    perPage: 24,
    searchTerm: '',
    tinyMCECallback: null,   // set when mode === 'tinymce'
    selectedIds: [],         // for gallery multi-select
};

/**
 * Open the photo library modal.
 * @param {string} mode    — 'featured', 'gallery', or 'tinymce'
 * @param {Function} [cb]  — TinyMCE callback (only when mode === 'tinymce')
 */
function openPhotoLibrary(mode, cb = null) {
    console.log('openPhotoLibrary called with mode:', mode);
    
    libraryState.mode = mode;
    libraryState.tinyMCECallback = cb;
    libraryState.currentPage = 1;
    libraryState.searchTerm = '';
    libraryState.selectedIds = [];

    // Update subtitle
    const subtitles = {
        featured: 'Pick one image for the featured slot',
        gallery:  'Pick one or more images for the gallery',
        tinymce:  'Pick an image to insert into the editor'
    };
    document.getElementById('libraryModalSubtitle').textContent = subtitles[mode] || '';
    document.getElementById('librarySearchInput').value = '';

    const modal = document.getElementById('photoLibraryModal');
    console.log('Modal element:', modal);
    
    modal.classList.remove('hidden');
    console.log('Modal should now be visible');
    
    loadLibraryPage(1);
}

function closePhotoLibrary() {
    document.getElementById('photoLibraryModal').classList.add('hidden');
    libraryState.tinyMCECallback = null;
}

// ─── Load a page of images ────────────────────────────────────────────────
async function loadLibraryPage(page) {
    libraryState.currentPage = page;

    const grid    = document.getElementById('libraryGrid');
    const loading = document.getElementById('libraryLoadingState');
    const empty   = document.getElementById('libraryEmptyState');

    grid.innerHTML    = '';
    loading.classList.remove('hidden');
    empty.classList.add('hidden');

    try {
        let url = `/admin/blog/photo-library?per_page=${libraryState.perPage}&page=${page}`;
        if (libraryState.searchTerm) url += `&search=${encodeURIComponent(libraryState.searchTerm)}`;

        const res   = await fetch(url);
        const data  = await res.json();   // Laravel paginated JSON

        libraryState.totalPages = data.last_page;
        libraryState.totalItems = data.total;

        loading.classList.add('hidden');

        if (data.data.length === 0) {
            empty.classList.remove('hidden');
            updatePagination();
            return;
        }

        // Render cards
        data.data.forEach(img => {
            grid.appendChild(buildLibraryCard(img));
        });

        updatePagination();
    } catch (err) {
        loading.classList.add('hidden');
        console.error('Photo library fetch error:', err);
    }
}

// ─── Build a single image card ────────────────────────────────────────────
function buildLibraryCard(img) {
    const card = document.createElement('div');
    card.className = 'library-card relative border border-gray-200 rounded-lg overflow-hidden cursor-pointer hover:border-indigo-400 transition';
    card.dataset.id  = img.id;
    card.dataset.url = img.url;
    card.dataset.alt = img.alt_text || '';

    card.innerHTML = `
        <img src="${img.url}" alt="${img.alt_text || ''}" class="w-full h-36 object-cover">
        <div class="p-2 bg-white">
            <p class="text-xs text-gray-500 truncate">${img.alt_text || 'No alt text'}</p>
            <p class="text-xs text-gray-400">${img.created}</p>
        </div>
        <!-- action buttons (pencil + trash) — appear on hover -->
        <div class="absolute top-2 right-2 flex gap-1">
            <button type="button" data-action="edit-alt" data-img-id="${img.id}" data-img-alt="${(img.alt_text||'').replace(/"/g, '&quot;')}"
                    class="library-card-delete bg-white bg-opacity-90 text-gray-600 hover:text-indigo-600 p-1 rounded shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>
            <button type="button" data-action="delete" data-img-id="${img.id}"
                    class="library-card-delete bg-white bg-opacity-90 text-gray-600 hover:text-red-600 p-1 rounded shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
        <!-- attached-to-post badge -->
        ${img.post_id ? `<div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs text-center py-0.5">Attached to post</div>` : ''}
    `;

    // Main card click handler
    card.addEventListener('click', (e) => {
        // Ignore if clicking on action buttons
        if (e.target.closest('[data-action]')) return;
        handleCardClick(card, img);
    });

    // Action button handlers (event delegation)
    card.querySelector('[data-action="edit-alt"]')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const id = this.dataset.imgId;
        const alt = this.dataset.imgAlt;
        openAltEdit(id, alt);
    });

    card.querySelector('[data-action="delete"]')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const id = this.dataset.imgId;
        deleteLibraryImage(id);
    });

    return card;
}

// ─── Handle card click depending on mode ─────────────────────────────────
function handleCardClick(card, img) {
    if (libraryState.mode === 'featured' || libraryState.mode === 'tinymce') {
        // Single-select: immediately resolve
        if (libraryState.mode === 'tinymce' && libraryState.tinyMCECallback) {
            libraryState.tinyMCECallback(img.url, { alt: img.alt_text || '' });
            closePhotoLibrary();
            return;
        }
        // Featured: store the path in the hidden input, show preview
        document.getElementById('featuredImageFromLibrary').value = img.url;
        document.getElementById('featuredPreview').classList.remove('hidden');
        document.getElementById('featuredImg').src = img.url;
        closePhotoLibrary();
        return;
    }

    if (libraryState.mode === 'gallery') {
        // Multi-select toggle
        const id = img.id;
        const idx = libraryState.selectedIds.indexOf(id);
        if (idx === -1) {
            libraryState.selectedIds.push(id);
            card.classList.add('selected');
        } else {
            libraryState.selectedIds.splice(idx, 1);
            card.classList.remove('selected');
        }
        updateGalleryConfirmBtn();
    }
}

// ─── Gallery: show / hide confirm button ─────────────────────────────────
function updateGalleryConfirmBtn() {
    let btn = document.getElementById('libraryConfirmGalleryBtn');
    if (libraryState.selectedIds.length > 0) {
        if (!btn) {
            btn = document.createElement('button');
            btn.id = 'libraryConfirmGalleryBtn';
            btn.className = 'px-4 py-1.5 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition';
            btn.textContent = 'Add selected';
            btn.addEventListener('click', confirmGallerySelection);
            // Append before the pagination info span
            document.getElementById('libraryPaginationInfo').parentNode.insertBefore(btn, document.getElementById('libraryPaginationInfo'));
        }
        btn.textContent = `Add ${libraryState.selectedIds.length} image${libraryState.selectedIds.length > 1 ? 's' : ''}`;
    } else if (btn) {
        btn.remove();
    }
}

function confirmGallerySelection() {
    // Store selected IDs in the hidden input (comma-separated)
    document.getElementById('galleryImagesFromLibrary').value = libraryState.selectedIds.join(',');

    // Show thumbnails in the preview area
    const preview = document.getElementById('imagesPreview');
    libraryState.selectedIds.forEach(id => {
        const card = document.querySelector(`.library-card[data-id="${id}"]`);
        if (card) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${card.dataset.url}" class="w-full h-32 object-cover rounded-lg border border-indigo-300">`;
            preview.appendChild(div);
        }
    });

    closePhotoLibrary();
}

// ─── Upload from the modal's upload bar ──────────────────────────────────
document.getElementById('libraryUploadInput').addEventListener('change', async function() {
    const files = this.files;
    if (!files.length) return;

    document.getElementById('libraryUploadStatus').textContent = `Uploading ${files.length} file(s)…`;

    const formData = new FormData();
    for (const f of files) formData.append('images[]', f);

    try {
        const res = await fetch('/admin/blog/photo-library/upload', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);

        document.getElementById('libraryUploadStatus').textContent = 'Uploaded! Refreshing…';
        this.value = '';   // reset file input
        await loadLibraryPage(1);  // reload page 1 so new images appear at the top
        document.getElementById('libraryUploadStatus').textContent = 'Upload complete';
    } catch (err) {
        document.getElementById('libraryUploadStatus').textContent = 'Upload failed';
        console.error(err);
    }
});

// ─── Search (client-side filter — for server-side, add ?search= to the API) ─
function searchLibrary(term) {
    libraryState.searchTerm = term.trim();
    libraryState.currentPage = 1;
    loadLibraryPage(1);
}

// ─── Pagination helpers ───────────────────────────────────────────────────
function updatePagination() {
    const prev = document.getElementById('libraryPrevBtn');
    const next = document.getElementById('libraryNextBtn');
    const info = document.getElementById('libraryPaginationInfo');

    prev.disabled = libraryState.currentPage <= 1;
    next.disabled = libraryState.currentPage >= libraryState.totalPages;

    const start = (libraryState.currentPage - 1) * libraryState.perPage + 1;
    const end   = Math.min(libraryState.currentPage * libraryState.perPage, libraryState.totalItems);
    info.textContent = libraryState.totalItems > 0
        ? `Showing ${start}–${end} of ${libraryState.totalItems} images`
        : '0 images';
}

// ─── Delete an image from the library ─────────────────────────────────────
async function deleteLibraryImage(id) {
    if (!confirm('Delete this image? It cannot be undone.')) return;

    try {
        const res = await fetch(`/admin/blog/photo-library/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const data = await res.json();
        if (!data.success) {
            alert(data.message || 'Could not delete.');
            return;
        }
        // Remove the card from DOM instantly
        const card = document.querySelector(`.library-card[data-id="${id}"]`);
        if (card) card.remove();
        libraryState.totalItems--;
    } catch (err) {
        alert('Delete failed');
        console.error(err);
    }
}

// ─── Alt-text edit mini-modal ─────────────────────────────────────────────
function openAltEdit(id, currentAlt) {
    document.getElementById('altEditImageId').value = id;
    document.getElementById('altEditInput').value   = currentAlt;
    document.getElementById('altEditModal').classList.remove('hidden');
}
function closeAltEdit() {
    document.getElementById('altEditModal').classList.add('hidden');
}
async function saveAltEdit() {
    const id  = document.getElementById('altEditImageId').value;
    const alt = document.getElementById('altEditInput').value;

    try {
        await fetch(`/admin/blog/photo-library/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ alt_text: alt })
        });
        // Update the card in the grid too
        const card = document.querySelector(`.library-card[data-id="${id}"]`);
        if (card) {
            card.dataset.alt = alt;
            card.querySelector('.library-card p').textContent = alt || 'No alt text';
        }
        closeAltEdit();
    } catch (err) {
        console.error(err);
    }
}
</script>
@endpush