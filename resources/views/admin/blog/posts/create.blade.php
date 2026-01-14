@extends('layouts.admin')

@section('page-title', isset($post) ? 'Edit Blog Post' : 'Create Blog Post')

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

                    <!-- Excerpt -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Excerpt <span class="text-red-500">*</span>
                        </label>
                        <textarea name="excerpt" 
                                  rows="3"
                                  required
                                  maxlength="500"
                                  placeholder="Brief summary of your post (max 500 characters)"
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('excerpt') border-red-500 bg-red-50 @else border-gray-300 @enderror">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            @error('excerpt')
                                <p class="text-red-500 text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500">Recommended: 150-160 characters</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Content (TinyMCE) -->
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
                    
                    <input type="file" 
                           name="featured_image" 
                           accept="image/*"
                           onchange="previewImage(event, 'featuredPreview')"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('featured_image') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Recommended size: 1200x630px (Max: 5MB)</p>
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
                </div>
            </div>

            <!-- Additional Images -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Additional Images</h3>
                
                <div>
                    <input type="file" 
                           name="images[]" 
                           multiple
                           accept="image/*"
                           onchange="previewMultipleImages(event)"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('images.*') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                    <p class="text-sm text-gray-500 mt-1">You can upload multiple images for your post (Max: 5MB each)</p>
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    
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
                    
                    <div id="imagesPreview" class="grid grid-cols-3 gap-4 mt-4"></div>
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
                            <span class="text-gray-900 font-medium">{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="text-gray-900 font-medium">{{ $post->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Views:</span>
                            <span class="text-gray-900 font-medium">{{ number_format($post->views ?? 0) }}</span>
                        </div>
                        @if(isset($post->comments))
                        <div>
                            <span class="text-gray-600">Comments:</span>
                            <span class="text-gray-900 font-medium">{{ $post->comments->count() }}</span>
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
                    <li>• Optimize for SEO</li>
                    <li>• Proofread before publishing</li>
                </ul>
            </div>
        </div>
    </div>
</form>

<!-- Image Manager Modal -->
<div id="imageManagerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Image Manager</h3>
                    <button onclick="closeImageManager()" 
                            class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Upload Section -->
                <div class="mb-4 border-b pb-4">
                    <input type="file" 
                           id="modalImageUpload" 
                           accept="image/*" 
                           multiple 
                           class="mb-2">
                    <button onclick="uploadModalImages()" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Upload Images
                    </button>
                </div>

                <!-- Images Grid -->
                <div id="modalImagesGrid" class="grid grid-cols-5 gap-4 max-h-96 overflow-y-auto"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
// Initialize TinyMCE
tinymce.init({
    selector: '#content',
    height: 600,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | code fullscreen | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    file_picker_types: 'image',
    file_picker_callback: function(callback, value, meta) {
        if (meta.filetype === 'image') {
            openImageManager(callback);
        }
    },
    images_upload_handler: function(blobInfo, success, failure) {
        uploadImageToTinyMCE(blobInfo, success, failure);
    }
});

// Auto-generate slug from title
document.getElementById('postTitle').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('postSlug').value = slug;
});

// Preview featured image
function previewImage(event, previewId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).classList.remove('hidden');
            document.getElementById('featuredImg').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Preview multiple images
function previewMultipleImages(event) {
    const files = event.target.files;
    const preview = document.getElementById('imagesPreview');
    preview.innerHTML = '';
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border border-gray-200">`;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
}

// Image Manager Functions
let imageCallback = null;

function openImageManager(callback) {
    if (callback) imageCallback = callback;
    document.getElementById('imageManagerModal').classList.remove('hidden');
    loadModalImages();
}

function closeImageManager() {
    document.getElementById('imageManagerModal').classList.add('hidden');
    imageCallback = null;
}

async function loadModalImages() {
    try {
        const response = await fetch('/admin/blog/images');
        const images = await response.json();
        const grid = document.getElementById('modalImagesGrid');
        
        grid.innerHTML = images.map(img => `
            <div class="border rounded overflow-hidden cursor-pointer hover:ring-2 hover:ring-indigo-500"
                 onclick="selectModalImage('${img.url}')">
                <img src="${img.url}" class="w-full h-32 object-cover">
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading images:', error);
    }
}

function selectModalImage(url) {
    if (imageCallback) {
        imageCallback(url, { alt: '' });
        closeImageManager();
    }
}

async function uploadModalImages() {
    const input = document.getElementById('modalImageUpload');
    const files = input.files;
    
    if (files.length === 0) {
        alert('Please select images to upload');
        return;
    }

    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append('images[]', files[i]);
    }

    try {
        const response = await fetch('/admin/blog/images/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        if (response.ok) {
            input.value = '';
            loadModalImages();
            alert('Images uploaded successfully');
        } else {
            alert('Upload failed');
        }
    } catch (error) {
        console.error('Error uploading images:', error);
        alert('Upload failed');
    }
}

async function uploadImageToTinyMCE(blobInfo, success, failure) {
    const formData = new FormData();
    formData.append('image', blobInfo.blob(), blobInfo.filename());

    try {
        const response = await fetch('/admin/blog/image/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        if (response.ok) {
            const data = await response.json();
            success(data.url);
        } else {
            failure('Upload failed');
        }
    } catch (error) {
        failure('Upload failed: ' + error.message);
    }
}
</script>
@endpush