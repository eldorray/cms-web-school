<x-layouts.frontend.app :school="$school" :title="'Berita - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">
                    @isset($category)
                        Berita: {{ $category->name }}
                    @else
                        Berita Terbaru
                    @endisset
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($posts as $post)
                        <article
                            class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow group">
                            <div class="aspect-video bg-gray-200 overflow-hidden">
                                @if ($post->getFirstMediaUrl('featured_image'))
                                    <img src="{{ $post->getFirstMediaUrl('featured_image') }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        @svg('fas-newspaper', 'w-12 h-12 text-gray-300')</div>
                                @endif
                            </div>
                            <div class="p-5">
                                @if ($post->category)
                                    <a href="{{ route('posts.category', $post->category) }}"
                                        class="inline-block px-2 py-1 text-xs font-medium rounded-full mb-2"
                                        style="background-color: {{ $post->category->color ?? '#3B82F6' }}20; color: {{ $post->category->color ?? '#3B82F6' }}">{{ $post->category->name }}</a>
                                @endif
                                <h2
                                    class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                                <p class="text-xs text-gray-500">{{ $post->published_at?->format('d M Y') }}</p>
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-primary hover:underline font-medium">Read
                                    More &rarr;</a>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-2 py-12 text-center text-gray-500">
                            <p>Belum ada berita</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-8">{{ $posts->links() }}</div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h3 class="font-semibold text-gray-900 mb-4">Kategori</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('posts.index') }}"
                                class="flex items-center justify-between text-gray-600 hover:text-primary {{ !isset($category) ? 'text-primary font-medium' : '' }}">
                                <span>Semua Berita</span>
                                <span class="text-sm text-gray-400">{{ $posts->total() }}</span>
                            </a>
                        </li>
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('posts.category', $cat) }}"
                                    class="flex items-center justify-between text-gray-600 hover:text-primary {{ isset($category) && $category->id == $cat->id ? 'text-primary font-medium' : '' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-sm text-gray-400">{{ $cat->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.frontend.app>
