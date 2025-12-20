<x-layouts.super-admin header="Kelola Sekolah">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari sekolah..."
                class="px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">@svg('fas-search', 'w-4 h-4')</button>
        </form>
        <a href="{{ route('super-admin.schools.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            @svg('fas-plus', 'w-4 h-4 mr-2') Tambah Sekolah
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sekolah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Domain</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berita</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($schools as $school)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                    @svg('fas-school', 'w-5 h-5 text-indigo-600')
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $school->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $school->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $school->domain }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $school->users_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $school->posts_count }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('super-admin.schools.toggle-status', $school) }}"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $school->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $school->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super-admin.schools.show', $school) }}"
                                    class="p-2 text-gray-500 hover:text-blue-600">@svg('fas-eye', 'w-4 h-4')</a>
                                <a href="{{ route('super-admin.schools.edit', $school) }}"
                                    class="p-2 text-gray-500 hover:text-blue-600">@svg('fas-pen', 'w-4 h-4')</a>
                                <form method="POST" action="{{ route('super-admin.schools.impersonate', $school) }}"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-500 hover:text-indigo-600"
                                        title="Masuk sebagai Admin">@svg('fas-user-secret', 'w-4 h-4')</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada sekolah</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($schools->hasPages())
            <div class="px-6 py-4 border-t">{{ $schools->links() }}</div>
        @endif
    </div>
</x-layouts.super-admin>
