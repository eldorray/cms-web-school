<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Agenda</h1>
        </div>

        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="max-w-2xl">
            @csrf @method('PUT')
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul
                        Agenda</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                            Mulai</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                            Selesai</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', $event->end_date?->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_all_day" value="1"
                        {{ old('is_all_day', $event->is_all_day) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Sepanjang hari</span>
                </label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_time"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time"
                            value="{{ old('start_time', $event->start_time) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_time"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Selesai</label>
                        <input type="time" name="end_time" id="end_time"
                            value="{{ old('end_time', $event->end_time) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="location"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna</label>
                    <input type="color" name="color" id="color"
                        value="{{ old('color', $event->color ?? '#3B82F6') }}"
                        class="w-16 h-10 border rounded-lg cursor-pointer">
                </div>

                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('description', $event->description) }}</textarea>
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_published" value="1"
                        {{ old('is_published', $event->is_published) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Publikasikan</span>
                </label>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.events.index') }}"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
