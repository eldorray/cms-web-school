<x-layouts.app>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Galeri</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola album foto dan video</p>
            </div>
            <a href="{{ route('admin.galleries.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                @svg('fas-plus', 'w-4 h-4 mr-2') Tambah Album
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galleries as $gallery)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="aspect-video bg-gray-200 dark:bg-gray-700 relative">
                        @if ($gallery->getFirstMediaUrl('cover'))
                            <img src="{{ $gallery->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">@svg('fas-images', 'w-12 h-12 text-gray-400')</div>
                        @endif
                        @if (!$gallery->is_published)
                            <span
                                class="absolute top-2 right-2 px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded">Draft</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-900 dark:text-white">{{ $gallery->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $gallery->items_count }} item</p>
                        <div class="flex items-center gap-2 mt-4">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}"
                                class="flex-1 py-2 text-center text-sm font-medium text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg">Kelola</a>
                            <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}"
                                onsubmit="return confirm('Hapus album ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-gray-500 hover:text-red-600">@svg('fas-trash', 'w-4 h-4')</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        @svg('fas-images', 'w-12 h-12 text-gray-300 mb-4')
                        <p>Belum ada album galeri</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($galleries->hasPages())
            <div class="mt-6">{{ $galleries->links() }}</div>
        @endif
    </div>
</x-layouts.app>
