<x-layouts.app>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pengaturan Sekolah</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola informasi dan tampilan sekolah</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf

            <!-- School Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Informasi Sekolah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Sekolah</label>
                        <input type="text" name="name" value="{{ old('name', $school->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat</label>
                        <textarea name="address" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('address', $school->address) }}</textarea>
                    </div>
                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $school->phone) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $school->email) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="website"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Website</label>
                        <input type="url" name="website" value="{{ old('website', $school->website) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Theme -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Warna Tema</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="theme_primary_color"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna Utama</label>
                        <input type="color" name="theme_primary_color"
                            value="{{ old('theme_primary_color', $school->theme_primary_color ?? '#3B82F6') }}"
                            class="w-full h-10 rounded-lg cursor-pointer">
                    </div>
                    <div>
                        <label for="theme_secondary_color"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna
                            Sekunder</label>
                        <input type="color" name="theme_secondary_color"
                            value="{{ old('theme_secondary_color', $school->theme_secondary_color ?? '#6366F1') }}"
                            class="w-full h-10 rounded-lg cursor-pointer">
                    </div>
                    <div>
                        <label for="theme_accent_color"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna Aksen</label>
                        <input type="color" name="theme_accent_color"
                            value="{{ old('theme_accent_color', $school->theme_accent_color ?? '#F59E0B') }}"
                            class="w-full h-10 rounded-lg cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Media Sosial</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="facebook"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Facebook</label>
                        <input type="url" name="facebook"
                            value="{{ old('facebook', $school->social_media['facebook'] ?? '') }}"
                            placeholder="https://facebook.com/..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                    <div>
                        <label for="instagram"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram</label>
                        <input type="url" name="instagram"
                            value="{{ old('instagram', $school->social_media['instagram'] ?? '') }}"
                            placeholder="https://instagram.com/..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                    <div>
                        <label for="youtube"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">YouTube</label>
                        <input type="url" name="youtube"
                            value="{{ old('youtube', $school->social_media['youtube'] ?? '') }}"
                            placeholder="https://youtube.com/..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                    <div>
                        <label for="twitter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Twitter/X</label>
                        <input type="url" name="twitter"
                            value="{{ old('twitter', $school->social_media['twitter'] ?? '') }}"
                            placeholder="https://twitter.com/..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan
                    Pengaturan</button>
            </div>
        </form>

        <!-- Logo Upload -->
        <form method="POST" action="{{ route('admin.settings.logo') }}" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            @csrf
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Logo Sekolah</h3>
            <div class="flex items-center gap-6">
                <div
                    class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                    @if ($school->getFirstMediaUrl('logo'))
                        <img src="{{ $school->getFirstMediaUrl('logo') }}" class="w-full h-full object-contain">
                    @else
                        @svg('fas-building', 'w-8 h-8 text-gray-400')
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" name="logo" accept="image/*" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, SVG. Maks 2MB</p>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload</button>
            </div>
        </form>

        <!-- Banner Upload -->
        <form method="POST" action="{{ route('admin.settings.banner') }}" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            @csrf
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Banner Homepage</h3>
            <p class="text-sm text-gray-500 mb-4">Gambar yang akan ditampilkan di bagian hero website</p>
            <div class="flex items-start gap-6">
                <div
                    class="w-48 h-24 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                    @if ($school->getFirstMediaUrl('banner'))
                        <img src="{{ $school->getFirstMediaUrl('banner') }}" class="w-full h-full object-cover">
                    @else
                        @svg('fas-image', 'w-8 h-8 text-gray-400')
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" name="banner" accept="image/*" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-2">Ukuran disarankan: 1920x600px. Format: JPG, PNG. Maks 5MB</p>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload</button>
            </div>
        </form>
    </div>
</x-layouts.app>
