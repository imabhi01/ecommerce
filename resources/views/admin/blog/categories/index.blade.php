@extends('layouts.admin')

@section('page-title', 'Blog Categories')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
        <h2 class="text-2xl font-bold text-gray-800">Blog Category Management</h2>
        <p class="text-gray-600">Organize your blog posts into categories</p>
    </div>
    <a href="{{ route('admin.blog.categories.create') }}" 
       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add New Category
    </a>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($categories as $category)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" 
                 alt="{{ $category->name }}" 
                 class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                <span class="text-6xl">📝</span>
            </div>
        @endif
        
        <div class="p-6">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->posts_count }} posts</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            
            @if($category->description)
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $category->description }}</p>
            @endif

            <div class="flex space-x-2 pt-4 border-t">
                <a href="{{ route('admin.blog.categories.edit', $category) }}" 
                   class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-center font-medium text-sm">
                    Edit
                </a>
                <form action="{{ route('admin.blog.categories.destroy', $category) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure? This will fail if posts exist in this category.');"
                      class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h2 class="text-2xl font-semibold mb-4">No blog categories found</h2>
            <p class="text-gray-600 mb-8">Start organizing your blog by creating categories</p>
            <a href="{{ route('admin.blog.categories.create') }}" 
               class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-block font-semibold">
                Create First Category
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($categories->hasPages())
<div class="mt-8">
    {{ $categories->links() }}
</div>
@endif
@endsection