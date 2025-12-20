<x-layouts.app>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Prestasi</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola prestasi siswa dan sekolah</p>
            </div>
            <a href="{{ route('admin.achievements.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                @svg('fas-plus', 'w-4 h-4 mr-2') Tambah Prestasi
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prestasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($achievements as $achievement)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900/50 flex items-center justify-center">
                                        @svg('fas-trophy', 'w-5 h-5 text-yellow-600')
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $achievement->title }}</p>
                                        <span
                                            class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">{{ $achievement->type_label }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $achievement->participant_name ?? '-' }}
                                @if ($achievement->participant_class)
                                    <br><span class="text-xs">Kelas {{ $achievement->participant_class }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $achievement->level_label }}
                                @if ($achievement->rank)
                                    <br><span class="text-xs font-medium">{{ $achievement->rank }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $achievement->year }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.achievements.edit', $achievement) }}"
                                        class="p-2 text-gray-500 hover:text-blue-600">@svg('fas-pen', 'w-4 h-4')</a>
                                    <form method="POST"
                                        action="{{ route('admin.achievements.destroy', $achievement) }}"
                                        onsubmit="return confirm('Hapus prestasi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-500 hover:text-red-600">@svg('fas-trash', 'w-4 h-4')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada prestasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($achievements->hasPages())
                <div class="px-6 py-4 border-t">{{ $achievements->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.app>
