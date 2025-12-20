<x-layouts.super-admin header="Dashboard">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                    @svg('fas-school', 'w-6 h-6 text-indigo-600')
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_schools'] }}</p>
                    <p class="text-sm text-gray-500">Total Sekolah</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    @svg('fas-check-circle', 'w-6 h-6 text-green-600')
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_schools'] }}</p>
                    <p class="text-sm text-gray-500">Sekolah Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    @svg('fas-users', 'w-6 h-6 text-blue-600')
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    @svg('fas-newspaper', 'w-6 h-6 text-yellow-600')
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_posts'] }}</p>
                    <p class="text-sm text-gray-500">Total Berita</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    @svg('fas-user-graduate', 'w-6 h-6 text-purple-600')
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_ppdb'] }}</p>
                    <p class="text-sm text-gray-500">Pendaftaran PPDB</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Schools -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Sekolah Terbaru</h3>
                <a href="{{ route('super-admin.schools.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat
                    Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentSchools as $school)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $school->name }}</p>
                            <p class="text-sm text-gray-500">{{ $school->domain }}</p>
                        </div>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $school->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $school->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">Belum ada sekolah</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Pengguna Terbaru</h3>
                <a href="{{ route('super-admin.users.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat
                    Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentUsers as $user)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600">{{ substr($user->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->school->name ?? 'Super Admin' }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">Belum ada pengguna</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.super-admin>
