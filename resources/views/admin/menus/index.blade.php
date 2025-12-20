<x-layouts.app>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Menu Website</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola navigasi website</p>
            </div>
            <a href="{{ route('admin.menus.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                @svg('fas-plus', 'w-4 h-4 mr-2') Tambah Menu
            </a>
        </div>

        <!-- Location Tabs -->
        <div class="flex gap-2">
            @foreach ($locations as $key => $label)
                <a href="{{ route('admin.menus.index', ['location' => $key]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg {{ $location == $key ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">{{ $label }}</a>
            @endforeach
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Menu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($menus as $menu)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($menu->icon)
                                        <span class="mr-2">@svg($menu->icon, 'w-4 h-4 text-gray-500')</span>
                                    @endif
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $menu->title }}</span>
                                </div>
                                @if ($menu->children && $menu->children->count())
                                    <div class="ml-6 mt-2 space-y-1">
                                        @foreach ($menu->children as $child)
                                            <div
                                                class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 py-1">
                                                <span>└ {{ $child->title }}</span>
                                                <a href="{{ route('admin.menus.edit', $child) }}"
                                                    class="text-blue-600 hover:text-blue-700">Edit</a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $menu->url ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if ($menu->is_active)
                                    <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>@else<span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.menus.edit', $menu) }}"
                                        class="p-2 text-gray-500 hover:text-blue-600">@svg('fas-pen', 'w-4 h-4')</a>
                                    <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                                        onsubmit="return confirm('Hapus menu ini?')">@csrf @method('DELETE')<button
                                            type="submit"
                                            class="p-2 text-gray-500 hover:text-red-600">@svg('fas-trash', 'w-4 h-4')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada menu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
