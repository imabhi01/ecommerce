@extends('layouts.admin')

@section('page-title', 'Edit Blog Category')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog.categories.index') }}" 
       class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Blog Categories
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Blog Category: {{ $category->name }}</h2>
</div>

<div class="max-w-3xl">
    <form action="{{ route('admin.blog.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($category->image)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <img src="{{ asset('storage/' . $category->image) }}" 
                     alt="{{ $category->name }}" 
                     class="w-full h-64 object-cover rounded-lg">
            </div>
            @endif

            <!-- New Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $category->image ? 'Change Image' : 'Category Image' }}
                </label>
                <input type="file" 
                       name="image" 
                       accept="image/*"
                       onchange="previewImage(event)"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                    <img id="preview" class="w-full h-64 object-cover rounded-lg">
                </div>
            </div>

            <!-- Active Status -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex space-x-4 pt-6 border-t">
                <button type="submit" 
                        class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                    Update Category
                </button>
                <a href="{{ route('admin.blog.categories.index') }}" 
                   class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-300 font-semibold">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection