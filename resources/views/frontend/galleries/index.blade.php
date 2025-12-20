<x-layouts.frontend.app :school="$school" :title="'Galeri - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Galeri Kegiatan</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($galleries as $gallery)
                <a href="{{ route('galleries.show', $gallery) }}" class="group relative">
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-200">
                        @if ($gallery->getFirstMediaUrl('cover'))
                            <img src="{{ $gallery->getFirstMediaUrl('cover') }}" alt="{{ $gallery->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">@svg('fas-images', 'w-12 h-12 text-gray-400')</div>
                        @endif
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent rounded-xl flex flex-col justify-end p-4">
                        <h3 class="font-medium text-white">{{ $gallery->title }}</h3>
                        <p class="text-sm text-white/80">{{ $gallery->items_count }} foto</p>
                    </div>
                </a>
            @empty
                <div class="col-span-4 py-12 text-center text-gray-500">
                    <p>Belum ada album galeri</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $galleries->links() }}</div>
    </div>
</x-layouts.frontend.app>
