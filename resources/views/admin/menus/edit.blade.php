<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.menus.index') }}" class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Menu</h1>
        </div>

        <form method="POST" action="{{ route('admin.menus.update', $menu) }}" class="max-w-xl">
            @csrf @method('PUT')
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border p-6 space-y-6">
                <div>
                    <label for="title"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $menu->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                </div>
                <div>
                    <label for="url"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL</label>
                    <input type="text" name="url" value="{{ old('url', $menu->url) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="location"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi</label>
                        <select name="location"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                            @foreach ($locations as $key => $label)
                                <option value="{{ $key }}" {{ $menu->location == $key ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="target"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target</label>
                        <select name="target"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <option value="_self" {{ $menu->target == '_self' ? 'selected' : '' }}>Sama</option>
                            <option value="_blank" {{ $menu->target == '_blank' ? 'selected' : '' }}>Baru</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="parent_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent</label>
                    <select name="parent_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <option value="">-- Root --</option>
                        @foreach ($parentMenus as $parent)
                            <option value="{{ $parent->id }}"
                                {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="icon"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $menu->icon) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                </div>
                <label class="flex items-center"><input type="checkbox" name="is_active" value="1"
                        {{ $menu->is_active ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded"><span
                        class="ml-3 text-sm text-gray-700">Aktif</span></label>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.menus.index') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
