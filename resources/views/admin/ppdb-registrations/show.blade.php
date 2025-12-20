<x-layouts.app>
    <div class="space-y-6" x-data="{ showModal: false, modalTitle: '', modalUrl: '', modalType: '' }">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.ppdb-registrations.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Pendaftaran</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Student Info -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Data Siswa</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->student_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">NISN</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->nisn ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">NIK</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->nik ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Tempat, Tgl Lahir</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->birth_place ?? '-' }},
                                {{ $ppdbRegistration->birth_date?->format('d M Y') ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Agama</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->religion ?? '-' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm text-gray-500">Alamat</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->address ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Asal Sekolah</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->previous_school ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Parent Info -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Data Orang Tua</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <dt class="text-sm text-gray-500">Nama Orang Tua</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->parent_name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Pekerjaan</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->parent_occupation ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Telepon</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->parent_phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->parent_email ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Documents -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Dokumen</h3>
                    @if ($ppdbRegistration->documents && count($ppdbRegistration->documents) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if (isset($ppdbRegistration->documents['kk']))
                                @php
                                    $kkUrl = asset('storage/' . $ppdbRegistration->documents['kk']);
                                    $kkExt = strtolower(
                                        pathinfo($ppdbRegistration->documents['kk'], PATHINFO_EXTENSION),
                                    );
                                    $kkType = in_array($kkExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'image' : 'pdf';
                                @endphp
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            @svg('fas-file', 'w-8 h-8 text-blue-500')
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Kartu Keluarga (KK)
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ basename($ppdbRegistration->documents['kk']) }}</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            @click="showModal = true; modalTitle = 'Kartu Keluarga (KK)'; modalUrl = '{{ $kkUrl }}'; modalType = '{{ $kkType }}'"
                                            class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 flex items-center gap-1">
                                            @svg('fas-eye', 'w-4 h-4')
                                            Lihat
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if (isset($ppdbRegistration->documents['akta']))
                                @php
                                    $aktaUrl = asset('storage/' . $ppdbRegistration->documents['akta']);
                                    $aktaExt = strtolower(
                                        pathinfo($ppdbRegistration->documents['akta'], PATHINFO_EXTENSION),
                                    );
                                    $aktaType = in_array($aktaExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])
                                        ? 'image'
                                        : 'pdf';
                                @endphp
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            @svg('fas-file', 'w-8 h-8 text-green-500')
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Akta Kelahiran</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ basename($ppdbRegistration->documents['akta']) }}</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            @click="showModal = true; modalTitle = 'Akta Kelahiran'; modalUrl = '{{ $aktaUrl }}'; modalType = '{{ $aktaType }}'"
                                            class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 flex items-center gap-1">
                                            @svg('fas-eye', 'w-4 h-4')
                                            Lihat
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Tidak ada dokumen yang diunggah.</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <!-- Status -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Status Pendaftaran</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-500">No. Pendaftaran</span>
                            <p class="font-mono font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->registration_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Status</span>
                            <p><span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $ppdbRegistration->status_color }}-100 text-{{ $ppdbRegistration->status_color }}-800">{{ $ppdbRegistration->status_label }}</span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Periode</span>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->period->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Tanggal Daftar</span>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $ppdbRegistration->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <form method="POST" action="{{ route('admin.ppdb-registrations.update-status', $ppdbRegistration) }}">
                    @csrf
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Ubah Status</h3>
                        <select name="status"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="pending" {{ $ppdbRegistration->status == 'pending' ? 'selected' : '' }}>
                                Menunggu</option>
                            <option value="verified" {{ $ppdbRegistration->status == 'verified' ? 'selected' : '' }}>
                                Terverifikasi</option>
                            <option value="accepted" {{ $ppdbRegistration->status == 'accepted' ? 'selected' : '' }}>
                                Diterima</option>
                            <option value="rejected" {{ $ppdbRegistration->status == 'rejected' ? 'selected' : '' }}>
                                Ditolak</option>
                        </select>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan
                            Status</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Document Preview Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false">
                </div>

                <!-- Modal panel -->
                <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl transform transition-all sm:max-w-6xl sm:w-full mx-4"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                    <!-- Header -->
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="modalTitle"></h3>
                        <div class="flex items-center gap-2">
                            <a :href="modalUrl" target="_blank" download
                                class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center gap-1">
                                @svg('fas-download', 'w-4 h-4')
                                Download
                            </a>
                            <button @click="showModal = false"
                                class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                @svg('fas-times', 'w-5 h-5')
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 max-h-[80vh] overflow-auto">
                        <template x-if="modalType === 'image'">
                            <img :src="modalUrl" class="max-w-full mx-auto rounded-lg shadow-sm"
                                alt="Document Preview">
                        </template>
                        <template x-if="modalType === 'pdf'">
                            <iframe :src="modalUrl"
                                class="w-full h-[75vh] rounded-lg border border-gray-200 dark:border-gray-600"></iframe>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
