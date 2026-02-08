@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            @if($posts->isNotEmpty())
                <article class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                    @if($posts->first()->featured_image)
                        <img src="{{ asset('storage/' . $posts->first()->featured_image) }}" 
                                alt="{{ $posts->first()->title }}"
                                class="w-full h-96 object-cover">
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                            <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full">
                                {{ $posts->first()->category->name }}
                            </span>
                            <span>{{ $posts->first()->published_at->format('M d, Y') }}</span>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">
                            <a href="{{ route('blog.show', $posts->first()->slug) }}" 
                                class="hover:text-indigo-600">
                                {{ $posts->first()->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 mb-4">{{ strip_tags($posts->first()->excerpt) }}</p>
                        <a href="{{ route('blog.show', $posts->first()->slug) }}" 
                            class="text-indigo-600 font-semibold hover:text-indigo-800">
                            Read More →
                        </a>
                    </div>
                </article>
            @endif

            {{-- Blog Posts Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($posts->skip(1) as $post)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($post->featured_image)
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-48 object-cover">
                            </a>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center gap-3 text-xs text-gray-600 mb-2">
                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">
                                    {{ $post->category->name }}
                                </span>
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                <a href="{{ route('blog.show', $post->slug) }}" 
                                    class="hover:text-indigo-600">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-3">
                                {{ Str::limit(strip_tags($post->excerpt), 100) }}
                            </p>
                            <a href="{{ route('blog.show', $post->slug) }}" 
                                class="text-indigo-600 text-sm font-semibold hover:text-indigo-800">
                                Read More →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-6">
            {{-- Categories --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.category', $category->slug) }}" 
                                class="flex justify-between items-center text-gray-700 hover:text-indigo-600">
                                <span>{{ $category->name }}</span>
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">
                                    {{ $category->posts_count }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Recent Posts --}}
            <div class="bg-white rounded-lg shadow-md p-6 sidebar-sticky">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Posts</h3>
                <ul class="space-y-">
                    @foreach($recentPosts as $post)
                        <li class="flex gap-2">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                        alt="{{ $post->title }}"
                                        class="w-16 h-16 rounded object-cover">
                            @endif
                            <div class="flex-2">
                                <a href="{{ route('blog.show', $post->slug) }}" 
                                    class="text-sm font-semibold text-gray-900 hover:text-indigo-600">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                                <p class="text-xs text-gray-500">
                                    {{ $post->published_at->format('M d, Y') }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection
