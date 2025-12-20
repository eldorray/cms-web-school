<x-layouts.super-admin :header="$school->name">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Informasi Sekolah</h3>
                    <a href="{{ route('super-admin.schools.edit', $school) }}"
                        class="text-sm text-indigo-600 hover:underline">Edit</a>
                </div>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Domain</dt>
                        <dd class="font-medium">{{ $school->domain }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="font-medium">{{ $school->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Telepon</dt>
                        <dd class="font-medium">{{ $school->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd><span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $school->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $school->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-sm text-gray-500">Alamat</dt>
                        <dd class="font-medium">{{ $school->address ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Admins -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Admin Sekolah</h3>
                <div class="space-y-3">
                    @foreach ($admins as $admin)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span
                                        class="text-sm font-medium text-indigo-600">{{ substr($admin->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $admin->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Stats -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Pengguna</span><span
                            class="font-medium">{{ $school->users_count }}</span></div>
                    <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Berita</span><span
                            class="font-medium">{{ $school->posts_count }}</span></div>
                    <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Event</span><span
                            class="font-medium">{{ $school->events_count }}</span></div>
                    <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Guru</span><span
                            class="font-medium">{{ $school->teachers_count }}</span></div>
                    <div class="flex justify-between py-2"><span class="text-gray-500">Galeri</span><span
                            class="font-medium">{{ $school->galleries_count }}</span></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 space-y-3">
                <h3 class="font-semibold text-gray-900 mb-4">Aksi</h3>
                <form method="POST" action="{{ route('super-admin.schools.impersonate', $school) }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Masuk sebagai
                        Admin</button>
                </form>
                <form method="POST" action="{{ route('super-admin.schools.toggle-status', $school) }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">{{ $school->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
