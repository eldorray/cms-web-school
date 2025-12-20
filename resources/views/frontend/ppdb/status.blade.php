<x-layouts.frontend.app :school="$school" :title="'Status PPDB - ' . $school->name">
    <div class="bg-white min-h-screen">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Cek Status Pendaftaran</h1>

                <!-- Search Form -->
                <form method="GET" class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6 mb-8">
                    <label for="no" class="block text-sm font-medium text-gray-700 mb-2">Nomor Pendaftaran</label>
                    <div class="flex gap-3">
                        <input type="text" name="no" id="no" value="{{ request('no') }}"
                            placeholder="PPDB-2024-0001" required
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white text-gray-800">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Cek</button>
                    </div>
                </form>

                <!-- Result -->
                @if (request('no'))
                    @if ($registration)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                                <p class="text-sm text-white/80">Nomor Pendaftaran</p>
                                <p class="text-xl font-bold font-mono">{{ $registration->registration_number }}</p>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Nama Siswa</span>
                                    <span class="font-medium text-gray-800">{{ $registration->student_name }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Periode</span>
                                    <span
                                        class="font-medium text-gray-800">{{ $registration->period->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Tanggal Daftar</span>
                                    <span
                                        class="font-medium text-gray-800">{{ $registration->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="text-gray-600">Status</span>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'verified' => 'bg-blue-100 text-blue-800',
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu Verifikasi',
                                            'verified' => 'Terverifikasi',
                                            'accepted' => 'Diterima',
                                            'rejected' => 'Ditolak',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$registration->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$registration->status] ?? $registration->status }}
                                    </span>
                                </div>
                            </div>

                            @if ($registration->status === 'accepted')
                                <div class="p-6 bg-green-50 border-t border-green-200">
                                    <p class="text-green-800 font-medium">🎉 Selamat! Anda diterima di
                                        {{ $school->name }}
                                    </p>
                                    <p class="text-sm text-green-700 mt-2">Silakan hubungi sekolah untuk informasi lebih
                                        lanjut mengenai daftar ulang.</p>
                                </div>
                            @elseif($registration->status === 'rejected')
                                <div class="p-6 bg-red-50 border-t border-red-200">
                                    <p class="text-red-800">Mohon maaf, pendaftaran Anda tidak dapat kami terima. Terima
                                        kasih atas minat Anda.</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-6 text-center">
                            <div
                                class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                                @svg('fas-exclamation-triangle', 'w-6 h-6 text-yellow-600')
                            </div>
                            <h3 class="font-semibold text-yellow-800 mb-2">Data Tidak Ditemukan</h3>
                            <p class="text-sm text-yellow-700">Nomor pendaftaran "{{ request('no') }}" tidak ditemukan.
                                Pastikan nomor yang Anda masukkan benar.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layouts.frontend.app>
