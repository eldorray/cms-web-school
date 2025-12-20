<x-layouts.frontend.app :school="$school" :title="$school->name . ' - Website Resmi'">
    <!-- Hero Section -->
    <section
        class="relative bg-gradient-to-br from-primary via-secondary to-primary text-white overflow-hidden min-h-[500px]">
        <!-- Background Image (Dynamic Banner) -->
        @if ($school->getFirstMediaUrl('banner'))
            <div class="absolute inset-0">
                <img src="{{ $school->getFirstMediaUrl('banner') }}" alt="Banner {{ $school->name }}"
                    class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-primary/90 via-primary/70 to-transparent"></div>
        @else
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"white\" opacity=\"0.05\"/></pattern></defs><rect fill=\"url(%23grain)\" width=\"100\" height=\"100\"/></svg>
            </div>
@endif
        <div class="container
                mx-auto px-4 py-20 relative">
                <div class="max-w-3xl">
                    <h1 class="text-secondary text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Selamat Datang di
                        {{ $school->name }}</h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-8">
                        {{ $school->tagline ?? 'Membangun Generasi Unggul dan Berkarakter' }}</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('ppdb.index') }}"
                            class="px-6 py-3 bg-accent text-gray-900 font-semibold rounded-lg hover:bg-yellow-400 transition-colors">Daftar
                            PPDB</a>
                        <a href="{{ route('posts.index') }}"
                            class="px-6 py-3 bg-white/20 text-white font-semibold rounded-lg hover:bg-white/30 transition-colors backdrop-blur-sm">Berita
                            Terbaru</a>
                    </div>
                </div>
            </div>
    </section>

    <!-- Stats -->
    <section class="container mx-auto px-4 -mt-8 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl p-6 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">{{ $teachers->count() }}+</p>
                <p class="text-sm text-gray-600">Guru & Staff</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">{{ $achievements->count() }}+</p>
                <p class="text-sm text-gray-600">Prestasi</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">{{ $galleries->count() }}+</p>
                <p class="text-sm text-gray-600">Album Galeri</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-primary">{{ $posts->count() }}+</p>
                <p class="text-sm text-gray-600">Berita</p>
            </div>
        </div>
    </section>

    <!-- Latest News -->
    <section class="container mx-auto px-4 py-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Berita Terbaru</h2>
            <a href="{{ route('posts.index') }}" class="text-primary hover:underline font-medium">Lihat Semua
                &rarr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts->take(6) as $post)
                <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="aspect-video bg-gray-200 overflow-hidden">
                        @if ($post->getFirstMediaUrl('featured_image'))
                            <img src="{{ $post->getFirstMediaUrl('featured_image') }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">@svg('fas-newspaper', 'w-12 h-12 text-gray-300')
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        @if ($post->category)
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full mb-2"
                                style="background-color: {{ $post->category->color ?? '#3B82F6' }}20; color: {{ $post->category->color ?? '#3B82F6' }}">{{ $post->category->name }}</span>
                        @endif
                        <h3
                            class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                        <p class="text-xs text-gray-500">{{ $post->published_at?->format('d M Y') }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <!-- Upcoming Events -->
    @if ($events->count())
        <section class="bg-gray-100 py-16">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Agenda Mendatang</h2>
                    <a href="{{ route('events.index') }}" class="text-primary hover:underline font-medium">Lihat Semua
                        &rarr;</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                        <div class="bg-white rounded-xl shadow-sm p-6 flex gap-4">
                            <div class="w-16 h-16 rounded-lg flex flex-col items-center justify-center text-white flex-shrink-0"
                                style="background-color: {{ $event->color ?? 'var(--primary-color)' }}">
                                <span class="text-xs font-medium">{{ $event->start_date->format('M') }}</span>
                                <span class="text-2xl font-bold">{{ $event->start_date->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $event->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $event->location ?? 'Sekolah' }}</p>
                                @if (!$event->is_all_day && $event->start_time)
                                    <p class="text-xs text-gray-400 mt-1">{{ $event->start_time }} -
                                        {{ $event->end_time }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Achievements -->
    @if ($achievements->count())
        <section class="container mx-auto px-4 py-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Prestasi Sekolah</h2>
                <a href="{{ route('achievements.index') }}" class="text-primary hover:underline font-medium">Lihat
                    Semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($achievements as $achievement)
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                @svg('fas-trophy', 'w-6 h-6 text-white')
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $achievement->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $achievement->rank }} -
                                    {{ $achievement->level_label }}</p>
                                @if ($achievement->participant_name)
                                    <p class="text-xs text-gray-500">{{ $achievement->participant_name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Teacher -->
    @if ($teachers->count())
        <section class="bg-gray-100 py-16">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Guru & Tenaga Kependidikan</h2>
                    <a href="{{ route('teachers.index') }}" class="text-primary hover:underline font-medium">Lihat
                        Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($teachers as $teacher)
                        <div
                            class="bg-white rounded-xl shadow-sm overflow-hidden text-center group hover:shadow-lg transition-shadow">
                            <div class="aspect-[3/4] bg-gray-200 overflow-hidden">
                                @if ($teacher->getFirstMediaUrl('photo'))
                                    <img src="{{ $teacher->getFirstMediaUrl('photo') }}" alt="{{ $teacher->name }}"
                                        class="w-full h-full object-cover group-hover:scale-90 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                        @svg('fas-user', 'w-16 h-16 text-gray-400')
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900">{{ $teacher->name }}</h3>
                                <p class="text-sm text-primary">{{ $teacher->position_label }}</p>
                                @if ($teacher->subject)
                                    <p class="text-xs text-gray-500 mt-1">{{ $teacher->subject }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery -->
    @if ($galleries->count())
        <section class="bg-gray-900 text-white py-16">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold">Galeri Kegiatan</h2>
                    <a href="{{ route('galleries.index') }}" class="text-white/80 hover:text-white font-medium">Lihat
                        Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($galleries as $gallery)
                        <a href="{{ route('galleries.show', $gallery) }}"
                            class="group relative aspect-square rounded-xl overflow-hidden">
                            @if ($gallery->getFirstMediaUrl('cover'))
                                <img src="{{ $gallery->getFirstMediaUrl('cover') }}" alt="{{ $gallery->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                    @svg('fas-images', 'w-12 h-12 text-gray-500')</div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                <h3 class="font-medium text-white">{{ $gallery->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA PPDB -->
    <section class="container mx-auto px-4 py-16">
        <div class="bg-gradient-to-r from-secondary to-primary rounded-2xl p-8 md:p-12 text-primary text-center">
            <h2 class="text-2xl md:text-4xl font-bold mb-4">Bergabunglah Bersama Kami!</h2>
            <p class="text-lg md:text-xl text-primary/90 mb-8 max-w-2xl mx-auto">Pendaftaran Peserta Didik Baru (PPDB)
                telah dibuka. Daftarkan putra-putri Anda sekarang!</p>
            <a href="{{ route('ppdb.index') }}"
                class="inline-block px-8 py-4 bg-primary text-white font-bold rounded-lg hover:bg-gray-100 transition-colors">Daftar
                Sekarang</a>
        </div>
    </section>
</x-layouts.frontend.app>
