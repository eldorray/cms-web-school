<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.ppdb-periods.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Periode PPDB</h1>
        </div>

        <form method="POST" action="{{ route('admin.ppdb-periods.store') }}" class="max-w-2xl">
            @csrf
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Periode</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            placeholder="Contoh: PPDB Gelombang 1"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="academic_year"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Ajaran</label>
                        <input type="text" name="academic_year" id="academic_year" value="{{ old('academic_year') }}"
                            required placeholder="2024/2025"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="quota"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kuota
                            (opsional)</label>
                        <input type="number" name="quota" id="quota" value="{{ old('quota') }}" min="1"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                            Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                            Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="requirements"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Persyaratan</label>
                    <textarea name="requirements" id="requirements" rows="4" placeholder="Tuliskan persyaratan pendaftaran..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('requirements') }}</textarea>
                </div>

                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Aktifkan periode ini</span>
                </label>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.ppdb-periods.index') }}"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
