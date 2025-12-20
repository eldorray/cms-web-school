<x-layouts.frontend.app :school="$school" :title="'Agenda - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Kalender Akademik</h1>

        <!-- Upcoming Events -->
        @if ($upcomingEvents->count())
            <section class="mb-12">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Agenda Mendatang</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($upcomingEvents as $event)
                        <div class="bg-white rounded-xl shadow-sm p-6 flex gap-4 border-l-4"
                            style="border-color: {{ $event->color ?? 'var(--primary-color)' }}">
                            <div class="w-16 h-16 rounded-lg flex flex-col items-center justify-center text-white flex-shrink-0"
                                style="background-color: {{ $event->color ?? 'var(--primary-color)' }}">
                                <span class="text-xs font-medium">{{ $event->start_date->format('M') }}</span>
                                <span class="text-2xl font-bold">{{ $event->start_date->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $event->title }}</h3>
                                @if ($event->location)
                                    <p class="text-sm text-gray-500 mb-1">@svg('fas-map-marker-alt', 'w-3 h-3 inline mr-1') {{ $event->location }}</p>
                                @endif
                                @if (!$event->is_all_day && $event->start_time)
                                    <p class="text-xs text-gray-400">@svg('fas-clock', 'w-3 h-3 inline mr-1') {{ $event->start_time }} -
                                        {{ $event->end_time }}</p>
                                @endif
                                @if ($event->description)
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $event->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Past Events -->
        <section>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Agenda Sebelumnya</h2>
            @if ($pastEvents->count())
                <div class="space-y-4">
                    @foreach ($pastEvents as $event)
                        <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4 opacity-75">
                            <div
                                class="w-12 h-12 rounded-lg flex flex-col items-center justify-center text-white text-sm flex-shrink-0 bg-gray-400">
                                <span class="text-xs">{{ $event->start_date->format('M') }}</span>
                                <span class="font-bold">{{ $event->start_date->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-700">{{ $event->title }}</h3>
                                <p class="text-xs text-gray-500">{{ $event->start_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $pastEvents->links() }}</div>
            @else
                <p class="text-gray-500">Belum ada agenda sebelumnya.</p>
            @endif
        </section>
    </div>
</x-layouts.frontend.app>
