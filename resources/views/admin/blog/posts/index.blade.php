@extends('layouts.admin')

@section('page-title', 'Blog Posts')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
        <h2 class="text-2xl font-bold text-gray-800">Blog Post Management</h2>
        <p class="text-gray-600">Create and manage your blog content</p>
    </div>
    <a href="{{ route('admin.blog.posts.create') }}" 
       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add New Post
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.blog.posts.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" 
                   name="search" 
                   placeholder="Search posts..." 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <select name="category" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                Filter
            </button>
            <a href="{{ route('admin.blog.posts.index') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-semibold">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Posts Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Title</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Post Image</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Category</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Author</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Views</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6">
                        <span class="text-blue-800 text-sm">
                            <p class="font-semibold text-gray-900">{{ Str::limit($post->title, 50) }}</p>
                            <p class="text-sm text-gray-600">{{ Str::limit(strip_tags($post->excerpt), 60) }}</p>
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-16 h-16 object-cover rounded-lg mr-4">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                    <span class="text-gray-400 text-2xl">📝</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-8">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $post->category->name }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-gray-900">{{ $post->author->name }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <span class="text-gray-600">{{ $post->views }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('blog.show', $post->slug) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800"
                               title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.blog.posts.edit', $post) }}" 
                               class="text-indigo-600 hover:text-indigo-800"
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.blog.posts.destroy', $post) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12">
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <p class="text-xl font-semibold mb-2">No blog posts found</p>
                            <p class="mb-4">Start creating content for your blog</p>
                            <a href="{{ route('admin.blog.posts.create') }}" 
                               class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 inline-block">
                                Create First Post
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection