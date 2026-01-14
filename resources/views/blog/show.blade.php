@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Breadcrumb --}}
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="/" class="hover:text-indigo-600">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-indigo-600">Blog</a></li>
                <li>/</li>
                <li><a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-indigo-600">{{ $post->category->name }}</a></li>
            </ol>
        </nav>

        {{-- Article Header --}}
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-8">
                <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full">
                        {{ $post->category->name }}
                    </span>
                    <span>{{ $post->published_at->format('F d, Y') }}</span>
                    <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                </div>

                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                @if($post->author)
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($post->author->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $post->author->name }}</p>
                            <p class="text-sm text-gray-600">Author</p>
                        </div>
                    </div>
                @endif

                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}"
                         class="w-full h-96 object-cover rounded-lg mb-8">
                @endif

                {{-- Social Share Buttons --}}
                <div class="flex items-center gap-3 mb-8 pb-8 border-b">
                    <span class="text-sm font-semibold text-gray-700">Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" 
                       target="_blank"
                       class="bg-sky-500 text-white px-4 py-2 rounded hover:bg-sky-600 text-sm">
                        Twitter
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" 
                       target="_blank"
                       class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 text-sm">
                        LinkedIn
                    </a>
                    <button onclick="copyToClipboard()" 
                            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                        Copy Link
                    </button>
                </div>

                {{-- Article Content --}}
                <div class="blog-content text-gray-800 text-lg leading-relaxed">
                    {!! $post->content !!}
                </div>
            </div>
        </article>

        {{-- Comments Section --}}
        <div class="bg-white rounded-lg shadow-md p-8 mt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                Comments ({{ $post->comments->count() }})
            </h2>

            {{-- Comment Form --}}
            @auth
                <form action="{{ route('blog.comments.store', $post) }}" method="POST" class="mb-8">
                    @csrf
                    <textarea name="content" rows="4" 
                              placeholder="Share your thoughts..."
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              required></textarea>
                    <button type="submit" 
                            class="mt-3 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Post Comment
                    </button>
                </form>
            @else
                <p class="text-gray-600 mb-8">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">Login</a> to post a comment.
                </p>
            @endauth

            {{-- Comments List --}}
            <div class="space-y-6">
                @forelse($post->comments as $comment)
                    <div class="border-b pb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700">{{ $comment->content }}</p>
                                
                                {{-- Rating Stars --}}
                                @if($comment->rating)
                                    <div class="flex items-center gap-1 mt-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>
        </div>

        {{-- Related Posts --}}
        @if($relatedPosts->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            @if($relatedPost->featured_image)
                                <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                         alt="{{ $relatedPost->title }}"
                                         class="w-full h-40 object-cover">
                                </a>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                       class="hover:text-indigo-600">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm">
                                    {{ Str::limit($relatedPost->excerpt, 80) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    </script>
@endsection
