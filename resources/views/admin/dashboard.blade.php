<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Selamat datang di panel admin CMS Sekolah</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Published Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        @svg('fas-newspaper', 'w-6 h-6 text-blue-600 dark:text-blue-400')
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Berita Terpublikasi</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['published_posts'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        @svg('fas-calendar-days', 'w-6 h-6 text-green-600 dark:text-green-400')
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Agenda Mendatang</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['events'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Teachers -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                        @svg('fas-chalkboard-user', 'w-6 h-6 text-purple-600 dark:text-purple-400')
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Guru & Staff Aktif</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['teachers'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Unread Messages -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        @svg('fas-envelope', 'w-6 h-6 text-yellow-600 dark:text-yellow-400')
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesan Belum Dibaca</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['unread_messages'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Registrations -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                        @svg('fas-user-plus', 'w-6 h-6 text-red-600 dark:text-red-400')
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendaftaran Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['pending_registrations'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                        @svg('fas-file-lines', 'w-6 h-6 text-indigo-600 dark:text-indigo-400')
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Berita</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['posts'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Berita Terbaru</h3>
                        <a href="{{ route('admin.posts.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">Lihat Semua</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentPosts as $post)
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                        class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate block">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $post->author->name }} • {{ $post->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                @if ($post->is_published)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Publik</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Draft</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Belum ada berita
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Agenda Mendatang</h3>
                        <a href="{{ route('admin.events.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">Lihat Semua</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($upcomingEvents as $event)
                        <div class="px-6 py-4">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex flex-col items-center justify-center">
                                    <span
                                        class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $event->start_date->format('M') }}</span>
                                    <span
                                        class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $event->start_date->format('d') }}</span>
                                </div>
                                <div class="ml-4 flex-1">
                                    <a href="{{ route('admin.events.edit', $event) }}"
                                        class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600">
                                        {{ $event->title }}
                                    </a>
                                    @if ($event->location)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            @svg('fas-location-dot', 'w-3 h-3 inline') {{ $event->location }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada agenda mendatang
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Messages & Registrations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Messages -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pesan Terbaru</h3>
                        <a href="{{ route('admin.contacts.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">Lihat Semua</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentMessages as $message)
                        <a href="{{ route('admin.contacts.show', $message) }}"
                            class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div class="flex items-start">
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 dark:text-white {{ !$message->is_read ? 'font-bold' : '' }}">
                                        {{ $message->name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 truncate">
                                        {{ $message->subject }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $message->created_at->diffForHumans() }}</p>
                                </div>
                                @if (!$message->is_read)
                                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada pesan
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Registrations -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pendaftaran Terbaru</h3>
                        <a href="{{ route('admin.ppdb-registrations.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">Lihat Semua</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentRegistrations as $registration)
                        <a href="{{ route('admin.ppdb-registrations.show', $registration) }}"
                            class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $registration->student_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $registration->registration_number }}</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $registration->status_color }}-100 text-{{ $registration->status_color }}-800 dark:bg-{{ $registration->status_color }}-900 dark:text-{{ $registration->status_color }}-300">
                                    {{ $registration->status_label }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada pendaftaran
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
