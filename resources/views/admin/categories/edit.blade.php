<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400">
                @svg('fas-arrow-left', 'w-5 h-5')
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Kategori</h1>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="max-w-xl">
            @csrf
            @method('PUT')

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama
                        Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
                </div>

                <div>
                    <label for="color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna</label>
                    <input type="color" name="color" id="color"
                        value="{{ old('color', $category->color ?? '#3B82F6') }}"
                        class="w-16 h-10 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                </label>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
