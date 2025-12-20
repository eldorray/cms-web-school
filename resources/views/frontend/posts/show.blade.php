<x-layouts.frontend.app :school="$school" :title="$post->title . ' - ' . $school->name" :description="$post->excerpt">
    <article class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('posts.index') }}" class="hover:text-primary">Berita</a>
                @if ($post->category)
                    <span class="mx-2">/</span>
                    <a href="{{ route('posts.category', $post->category) }}"
                        class="hover:text-primary">{{ $post->category->name }}</a>
                @endif
            </nav>

            <!-- Header -->
            <header class="mb-8">
                @if ($post->category)
                    <span class="inline-block px-3 py-1 text-sm font-medium rounded-full mb-4"
                        style="background-color: {{ $post->category->color ?? '#3B82F6' }}20; color: {{ $post->category->color ?? '#3B82F6' }}">{{ $post->category->name }}</span>
                @endif
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span>{{ $post->published_at?->format('d M Y') }}</span>
                    <span>•</span>
                    <span>{{ $post->view_count }} kali dibaca</span>
                </div>
            </header>

            <!-- Featured Image -->
            @if ($post->getFirstMediaUrl('featured_image'))
                <div class="aspect-video rounded-xl overflow-hidden mb-8">
                    <img src="{{ $post->getFirstMediaUrl('featured_image') }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none mb-12">
                {!! $post->content !!}
            </div>

            <!-- Share -->
            <div class="border-t border-gray-200 pt-6 mb-12">
                <p class="text-sm text-gray-500 mb-3">Bagikan:</p>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700">@svg('fab-facebook-f', 'w-5 h-5')</a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-gray-900">@svg('fab-x-twitter', 'w-5 h-5')</a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600">@svg('fab-whatsapp', 'w-5 h-5')</a>
                </div>
            </div>

            <!-- Related Posts -->
            @if ($relatedPosts->count())
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($relatedPosts as $related)
                            <a href="{{ route('posts.show', $related) }}" class="flex gap-4 group">
                                <div class="w-24 h-24 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                    @if ($related->getFirstMediaUrl('featured_image'))
                                        <img src="{{ $related->getFirstMediaUrl('featured_image') }}" alt=""
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 group-hover:text-primary line-clamp-2">
                                        {{ $related->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $related->published_at?->format('d M Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
</x-layouts.frontend.app>
