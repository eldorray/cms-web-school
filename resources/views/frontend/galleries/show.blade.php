<x-layouts.frontend.app :school="$school" :title="$gallery->title . ' - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('galleries.index') }}" class="hover:text-primary">Galeri</a>
            <span class="mx-2">/</span>
            <span>{{ $gallery->title }}</span>
        </nav>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $gallery->title }}</h1>
            @if ($gallery->event_date)
                <p class="text-gray-500">{{ $gallery->event_date->format('d M Y') }}</p>
            @endif
            @if ($gallery->description)
                <p class="text-gray-600 mt-4">{{ $gallery->description }}</p>
            @endif
        </div>

        <!-- Lightbox Gallery -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="{ lightbox: false, current: 0, items: {{ $gallery->items->map(fn($item) => ['url' => $item->getFirstMediaUrl('file'), 'caption' => $item->caption])->toJson() }} }">
            @foreach ($gallery->items as $index => $item)
                @if ($item->type === 'image')
                    <button @click="lightbox = true; current = {{ $index }}"
                        class="aspect-square rounded-lg overflow-hidden bg-gray-200 cursor-zoom-in">
                        <img src="{{ $item->getFirstMediaUrl('file') }}" alt="{{ $item->caption }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform">
                    </button>
                @else
                    <a href="{{ $item->video_url }}" target="_blank"
                        class="aspect-square rounded-lg overflow-hidden bg-gray-800 flex items-center justify-center">
                        @svg('fas-play-circle', 'w-12 h-12 text-white')
                    </a>
                @endif
            @endforeach

            <!-- Lightbox Modal -->
            <div x-show="lightbox" x-transition.opacity
                class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center"
                @keydown.escape.window="lightbox = false"
                @keydown.arrow-left.window="current = (current - 1 + items.length) % items.length"
                @keydown.arrow-right.window="current = (current + 1) % items.length">
                <button @click="lightbox = false"
                    class="absolute top-4 right-4 text-white/80 hover:text-white">@svg('fas-times', 'w-8 h-8')</button>
                <button @click="current = (current - 1 + items.length) % items.length"
                    class="absolute left-4 text-white/80 hover:text-white">@svg('fas-chevron-left', 'w-8 h-8')</button>
                <button @click="current = (current + 1) % items.length"
                    class="absolute right-4 text-white/80 hover:text-white">@svg('fas-chevron-right', 'w-8 h-8')</button>
                <div class="max-w-5xl max-h-[90vh] flex flex-col items-center">
                    <img :src="items[current]?.url" class="max-w-full max-h-[80vh] object-contain">
                    <p x-text="items[current]?.caption" class="text-white/80 mt-4 text-center"></p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.frontend.app>
