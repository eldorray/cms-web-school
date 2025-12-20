<x-layouts.frontend.app :school="$school" :title="'Pusat Download - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Pusat Download</h1>

        <!-- Category Tabs -->
        @php
            $categoryLabels = [
                'document' => 'Dokumen',
                'form' => 'Formulir',
                'regulation' => 'Peraturan',
                'material' => 'Materi',
                'other' => 'Lainnya',
            ];
        @endphp
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('downloads.index') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('category') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Semua</a>
            @foreach ($categories as $cat)
                <a href="{{ route('downloads.index', ['category' => $cat]) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium {{ request('category') == $cat ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">{{ $categoryLabels[$cat] ?? $cat }}</a>
            @endforeach
        </div>

        <div class="bg-white rounded-xl shadow-sm divide-y divide-gray-200">
            @forelse($downloads as $download)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                            @svg('fas-file-arrow-down', 'w-6 h-6 text-gray-500')
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $download->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $download->file_size_for_humans }} •
                                {{ $download->download_count }}x diunduh</p>
                        </div>
                    </div>
                    <a href="{{ route('downloads.download', $download) }}"
                        class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center gap-2">
                        @svg('fas-download', 'w-4 h-4')
                        <span class="hidden sm:inline">Download</span>
                    </a>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">
                    <p>Tidak ada file untuk diunduh</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $downloads->links() }}</div>
    </div>
</x-layouts.frontend.app>
