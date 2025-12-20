<x-layouts.frontend.app :school="$school" :title="'PPDB - ' . $school->name">
    <div class="bg-white min-h-screen">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Penerimaan Peserta Didik Baru</h1>
                <p class="text-lg text-gray-600">Daftarkan putra-putri Anda di {{ $school->name }}</p>
            </div>

            @if ($activePeriod)
                <div
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-gray-800 text-center mb-12">
                    <span class="inline-block px-4 py-1 bg-primary/20 rounded-full text-sm font-medium mb-4">Pendaftaran
                        Dibuka!</span>
                    <h2 class="text-2xl font-bold mb-2">{{ $activePeriod->name }}</h2>
                    <p class="text-lg mb-4">Tahun Ajaran {{ $activePeriod->academic_year }}</p>
                    <p class="text-gray-800/80 mb-6">Periode: {{ $activePeriod->start_date->format('d M Y') }} -
                        {{ $activePeriod->end_date->format('d M Y') }}</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('ppdb.create') }}"
                            class="px-8 py-3 bg-primary text-gray-800 font-bold rounded-lg hover:bg-gray-100 transition-colors">Daftar
                            Sekarang</a>
                        <a href="{{ route('ppdb.status') }}"
                            class="px-8 py-3 bg-accent text-gray-800 font-semibold rounded-lg hover:bg-white/30 transition-colors">Cek
                            Status</a>
                    </div>
                </div>

                @if ($activePeriod->requirements)
                    <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-8 mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Persyaratan Pendaftaran</h3>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($activePeriod->requirements)) !!}
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-gray-100 border border-gray-200 rounded-xl p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                        @svg('fas-calendar-xmark', 'w-8 h-8 text-gray-500')
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Pendaftaran Belum Dibuka</h2>
                    <p class="text-gray-600">Saat ini belum ada periode pendaftaran yang aktif. Silakan cek kembali
                        nanti.
                    </p>
                    <a href="{{ route('ppdb.status') }}"
                        class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cek
                        Status Pendaftaran</a>
                </div>
            @endif

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                        @svg('fas-file-lines', 'w-6 h-6 text-blue-600')
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">1. Isi Formulir</h3>
                    <p class="text-sm text-gray-600">Lengkapi data siswa dan orang tua pada formulir pendaftaran online
                    </p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                        @svg('fas-clock', 'w-6 h-6 text-yellow-600')
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">2. Verifikasi</h3>
                    <p class="text-sm text-gray-600">Tim kami akan memverifikasi data pendaftaran Anda</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        @svg('fas-check-circle', 'w-6 h-6 text-green-600')
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">3. Pengumuman</h3>
                    <p class="text-sm text-gray-600">Cek status pendaftaran secara online menggunakan nomor pendaftaran
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.frontend.app>
