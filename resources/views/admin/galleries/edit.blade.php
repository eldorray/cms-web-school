<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.galleries.index') }}"
                    class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $gallery->title }}</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Gallery Info -->
            <div class="lg:col-span-1">
                <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                        <div>
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                            <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('description', $gallery->description) }}</textarea>
                        </div>
                        <div>
                            <label for="cover"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sampul</label>
                            @if ($gallery->getFirstMediaUrl('cover'))
                                <img src="{{ $gallery->getFirstMediaUrl('cover') }}"
                                    class="w-full h-32 object-cover rounded-lg mb-2">
                            @endif
                            <input type="file" name="cover" accept="image/*" class="w-full text-sm text-gray-500">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1"
                                {{ $gallery->is_published ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Publikasikan</span>
                        </label>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- Gallery Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Add Item Form -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tambah Foto/Video</h3>
                    <form method="POST" action="{{ route('admin.galleries.items.store', $gallery) }}"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="flex gap-4">
                            <label class="flex items-center"><input type="radio" name="type" value="image" checked
                                    class="mr-2">Foto</label>
                            <label class="flex items-center"><input type="radio" name="type" value="video"
                                    class="mr-2">Video (YouTube)</label>
                        </div>
                        <div>
                            <input type="file" name="file" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700">
                        </div>
                        <div>
                            <input type="url" name="video_url" placeholder="URL YouTube (untuk video)"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <input type="text" name="caption" placeholder="Keterangan (opsional)"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Tambah</button>
                    </form>
                </div>

                <!-- Items Grid -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Item dalam Album
                        ({{ $gallery->items->count() }})</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($gallery->items as $item)
                            <div class="relative group">
                                <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                                    @if ($item->isImage() && $item->getFirstMediaUrl('file'))
                                        <img src="{{ $item->getFirstMediaUrl('file') }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full">@svg('fas-video', 'w-8 h-8 text-gray-400')</div>
                                    @endif
                                </div>
                                <form method="POST"
                                    action="{{ route('admin.galleries.items.destroy', [$gallery, $item]) }}"
                                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700">@svg('fas-trash', 'w-3 h-3')</button>
                                </form>
                                @if ($item->caption)
                                    <p class="text-xs text-gray-500 mt-1 truncate">{{ $item->caption }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full py-8 text-center text-gray-500">Belum ada item dalam album</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
