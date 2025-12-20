<x-layouts.frontend.app :school="$school" :title="'Guru & Staff - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Guru & Tenaga Kependidikan</h1>

        @php
            $positionLabels = [
                'kepala_sekolah' => 'Kepala Sekolah',
                'wakil_kepala' => 'Wakil Kepala Sekolah',
                'guru' => 'Guru',
                'staff_tu' => 'Tenaga Kependidikan',
                'pustakawan' => 'Pustakawan',
                'laboran' => 'Laboran',
                'satpam' => 'Satpam',
                'petugas_kebersihan' => 'Petugas Kebersihan',
                'lainnya' => 'Lainnya',
            ];
        @endphp

        @foreach (['kepala_sekolah', 'wakil_kepala', 'guru', 'staff_tu', 'pustakawan', 'laboran', 'satpam', 'petugas_kebersihan', 'lainnya'] as $position)
            @if (isset($teachers[$position]) && $teachers[$position]->count())
                <section class="mb-12">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ $positionLabels[$position] }}</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($teachers[$position] as $teacher)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden text-center group">
                                <div class="aspect-[3/4] bg-gray-200 overflow-hidden">
                                    @if ($teacher->getFirstMediaUrl('photo'))
                                        <img src="{{ $teacher->getFirstMediaUrl('photo') }}" alt="{{ $teacher->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                            @svg('fas-user', 'w-16 h-16 text-gray-400')
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900">{{ $teacher->name }}</h3>
                                    @if ($teacher->position_detail)
                                        <p class="text-sm text-primary">{{ $teacher->position_detail }}</p>
                                    @endif
                                    @if ($teacher->subject)
                                        <p class="text-xs text-gray-500 mt-1">{{ $teacher->subject }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    </div>
</x-layouts.frontend.app>
