<x-layouts.app>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Guru & Staff</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola data guru dan tenaga kependidikan</p>
            </div>
            <a href="{{ route('admin.teachers.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                @svg('fas-plus', 'w-4 h-4 mr-2') Tambah Guru/Staff
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($teachers as $teacher)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                            @if ($teacher->getFirstMediaUrl('photo'))
                                                <img src="{{ $teacher->getFirstMediaUrl('photo') }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <span
                                                    class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ substr($teacher->name, 0, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $teacher->name }}</p>
                                            @if ($teacher->subject)
                                                <p class="text-xs text-gray-500">{{ $teacher->subject }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $teacher->position_label }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $teacher->nip ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if ($teacher->is_active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                            class="p-2 text-gray-500 hover:text-blue-600">@svg('fas-pen', 'w-4 h-4')</a>
                                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}"
                                            onsubmit="return confirm('Hapus data guru/staff ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-500 hover:text-red-600">@svg('fas-trash', 'w-4 h-4')</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data
                                    guru/staff</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($teachers->hasPages())
                <div class="px-6 py-4 border-t">{{ $teachers->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.app>
