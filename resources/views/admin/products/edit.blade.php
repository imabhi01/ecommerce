@extends('layouts.admin')

@section('page-title', 'Edit Product')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" 
       class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Products
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Product: {{ $product->name }}</h2>
</div>

{{-- MAIN UPDATE FORM --}}
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

{{-- ================= LEFT COLUMN ================= --}}
<div class="lg:col-span-2 space-y-6">

{{-- BASIC INFO --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold mb-4">Basic Information</h3>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">Product Name *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Description *</label>
            <textarea name="description" rows="6" required
                class="w-full px-4 py-2 border rounded-lg">{{ old('description', $product->description) }}</textarea>
        </div>
    </div>
</div>

{{-- PRICING --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold mb-4">Pricing</h3>

    <div class="grid grid-cols-2 gap-4">
        <input type="number" step="0.01" name="price" value="{{ $product->price }}" required class="border rounded p-2">
        <input type="number" step="0.01" name="compare_price" value="{{ $product->compare_price }}" class="border rounded p-2">
    </div>
</div>

{{-- INVENTORY --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold mb-4">Inventory</h3>

    <div class="grid grid-cols-2 gap-4">
        <input type="text" name="sku" value="{{ $product->sku }}" required class="border rounded p-2">
        <input type="number" name="stock" value="{{ $product->stock }}" required min="0" class="border rounded p-2">
    </div>
</div>

{{-- EXISTING IMAGES --}}
@if($product->images->isNotEmpty())
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold mb-4">Existing Images</h3>

    <div class="grid grid-cols-4 gap-4">
        @foreach($product->images as $image)
        <div class="relative group">
            <img src="{{ asset('storage/'.$image->image_path) }}"
                 class="w-full h-32 object-cover rounded">

            <button type="button"
                onclick="deleteImage({{ $image->id }})"
                class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded opacity-0 group-hover:opacity-100">
                ✕
            </button>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ADD NEW IMAGES --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold mb-4">Add New Images</h3>

    <input type="file" name="images[]" multiple accept="image/*"
        class="border rounded p-2 w-full"
        onchange="previewImages(event)">

    <div id="imagePreview" class="grid grid-cols-4 gap-4 mt-4"></div>
</div>

</div>

{{-- ================= RIGHT SIDEBAR ================= --}}
<div class="space-y-6">

<div class="bg-white rounded-lg shadow-md p-6">
    <label class="flex items-center">
        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
        <span class="ml-2">Active</span>
    </label>

    <label class="flex items-center mt-2">
        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
        <span class="ml-2">Featured</span>
    </label>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <select name="category_id" required class="w-full border rounded p-2">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <button type="submit"
        class="w-full bg-indigo-600 text-white py-3 rounded font-semibold">
        Update Product
    </button>
</div>

</div>
</div>
</form>

{{-- ================= JS ================= --}}
<script>
function deleteImage(imageId) {
    if (!confirm('Delete this image?')) return;

    fetch(`/admin/products/images/${imageId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'DELETE'
        }
    }).then(() => location.reload());
}

function previewImages(event) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    [...event.target.files].forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `<img src="${e.target.result}" class="h-32 object-cover rounded">`;
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
