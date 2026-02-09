@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col lg:flex-row gap-8">

    <!-- Sidebar -->
    <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Categories</h2>
        <ul class="space-y-2">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('blog.category', $category->slug) }}" 
                       class="block px-3 py-2 rounded hover:bg-indigo-50 transition-colors {{ request()->segment(2) == $category->slug ? 'bg-indigo-100 font-semibold' : '' }}">
                        {{ $category->name }} 
                        <span class="text-gray-400 text-sm">({{ $category->published_posts_count }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1">
        <h1 class="text-2xl font-bold mb-6">Blog Categories</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 w-full bg-gray-200">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-40 object-cover">
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">{{ $category->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $category->published_posts_count }} posts</p>
                    </div>
                </a>
            @endforeach
        </div>
    </main>
</div>
@endsection
