<x-layouts.frontend.app :school="$school" :title="'Prestasi - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Prestasi Sekolah</h1>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-8">
            <form method="GET" class="flex flex-wrap gap-4">
                <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Filter</button>
                @if (request()->hasAny(['year', 'type', 'level']))
                    <a href="{{ route('achievements.index') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">Reset</a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($achievements as $achievement)
                <div
                    class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl overflow-hidden">
                    @if ($achievement->getFirstMediaUrl('image'))
                        <div class="aspect-video">
                            <img src="{{ $achievement->getFirstMediaUrl('image') }}" alt="{{ $achievement->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                @svg('fas-trophy', 'w-6 h-6 text-white')
                            </div>
                            <div class="flex-1">
                                <span
                                    class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">{{ $achievement->year }}</span>
                                <h3 class="font-semibold text-gray-900 mt-2">{{ $achievement->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    @if ($achievement->rank)
                                        <strong>{{ $achievement->rank }}</strong> -
                                    @endif
                                    {{ $achievement->level_label }}
                                </p>
                                @if ($achievement->participant_name)
                                    <p class="text-sm text-gray-500 mt-2">
                                        @svg('fas-user', 'w-3 h-3 inline mr-1')
                                        {{ $achievement->participant_name }}
                                        @if ($achievement->participant_class)
                                            (Kelas {{ $achievement->participant_class }})
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 text-center text-gray-500">
                    <p>Belum ada prestasi</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $achievements->links() }}</div>
    </div>
</x-layouts.frontend.app>
