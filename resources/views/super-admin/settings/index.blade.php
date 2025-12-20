<x-layouts.super-admin header="Pengaturan Platform">
    <form method="POST" action="{{ route('super-admin.settings.update') }}" class="max-w-2xl">
        @csrf @method('PUT')
        <div class="space-y-6">
            <!-- General -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi Platform</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Platform</label>
                        <input type="text" name="platform_name" value="{{ $settings['platform_name'] }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                        <input type="text" name="platform_tagline" value="{{ $settings['platform_tagline'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Support</label>
                        <input type="email" name="platform_email" value="{{ $settings['platform_email'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Pengaturan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tema Default</label>
                        <select name="default_theme" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="blue" {{ $settings['default_theme'] == 'blue' ? 'selected' : '' }}>Biru
                            </option>
                            <option value="green" {{ $settings['default_theme'] == 'green' ? 'selected' : '' }}>Hijau
                            </option>
                            <option value="red" {{ $settings['default_theme'] == 'red' ? 'selected' : '' }}>Merah
                            </option>
                            <option value="purple" {{ $settings['default_theme'] == 'purple' ? 'selected' : '' }}>Ungu
                            </option>
                            <option value="orange" {{ $settings['default_theme'] == 'orange' ? 'selected' : '' }}>Oranye
                            </option>
                        </select>
                    </div>
                    <label class="flex items-center py-2">
                        <input type="checkbox" name="allow_registration" value="1"
                            {{ $settings['allow_registration'] ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 rounded">
                        <span class="ml-3 text-sm text-gray-700">Izinkan registrasi sekolah baru</span>
                    </label>
                    <label class="flex items-center py-2">
                        <input type="checkbox" name="maintenance_mode" value="1"
                            {{ $settings['maintenance_mode'] ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded">
                        <span class="ml-3 text-sm text-gray-700">Mode Maintenance (website tidak dapat diakses
                            publik)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan
                    Pengaturan</button>
            </div>
        </div>
    </form>
</x-layouts.super-admin>
