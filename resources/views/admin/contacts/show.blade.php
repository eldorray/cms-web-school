<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.contacts.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Pesan</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $contact->subject }}</h2>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                    <span>Dari: <strong class="text-gray-900 dark:text-white">{{ $contact->name }}</strong></span>
                    <span>{{ $contact->email }}</span>
                    <span>{{ $contact->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>

        <div class="flex gap-3">
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                @svg('fas-reply', 'w-4 h-4 mr-2') Balas via Email
            </a>
            <form method="POST" action="{{ route('admin.contacts.toggle-read', $contact) }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200">
                    {{ $contact->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
