@extends('layouts.admin')

@section('page-title', 'Products')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
        <h2 class="text-2xl font-bold text-gray-800">Product Management</h2>
        <p class="text-gray-600">Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" 
       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add New Product
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" 
                   name="search" 
                   placeholder="Search products..." 
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
        <div class="flex space-x-2">
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                Filter
            </button>
            <a href="{{ route('admin.products.index') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-semibold">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Product</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Category</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Price</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Stock</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            @if($product->primaryImage)
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-800">
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-16 h-16 object-cover rounded-lg mr-4">
                                </a>
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-800">
                                        <span class="text-gray-400 text-2xl">📦</span>
                                    </a>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-800">
                                    <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                </a>
                                <p class="text-sm text-gray-600">SKU: {{ $product->sku }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <p class="font-semibold text-gray-900">${{ number_format($product->price, 2) }}</p>
                        @if($product->compare_price)
                            <p class="text-sm text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</p>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($product->stock > 10) bg-green-100 text-green-800
                            @elseif($product->stock > 0) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $product->stock }} units
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="text-indigo-600 hover:text-indigo-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
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
                    <td colspan="6" class="text-center py-12">
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-xl font-semibold mb-2">No products found</p>
                            <p class="mb-4">Start by adding your first product</p>
                            <a href="{{ route('admin.products.create') }}" 
                               class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 inline-block">
                                Add Product
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection