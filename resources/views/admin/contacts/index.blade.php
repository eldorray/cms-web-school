<x-layouts.app>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pesan Masuk</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $unreadCount }} pesan belum dibaca</p>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($messages as $message)
                    <a href="{{ route('admin.contacts.show', $message) }}"
                        class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ !$message->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white {{ !$message->is_read ? 'font-bold' : '' }}">{{ $message->name }}</span>
                                    @if (!$message->is_read)
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300 truncate">{{ $message->subject }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $message->email }} •
                                    {{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $message) }}"
                                onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600"
                                    onclick="event.stopPropagation()">@svg('fas-trash', 'w-4 h-4')</button>
                            </form>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        @svg('fas-inbox', 'w-12 h-12 mx-auto text-gray-300 mb-4')
                        <p>Tidak ada pesan</p>
                    </div>
                @endforelse
            </div>
            @if ($messages->hasPages())
                <div class="px-6 py-4 border-t">{{ $messages->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.app>
