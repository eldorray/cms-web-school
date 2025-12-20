<x-layouts.frontend.app :school="$school" :title="'Kontak - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Hubungi Kami</h1>
                <p class="text-gray-600 mb-8">Silakan hubungi kami melalui informasi di bawah ini atau kirimkan pesan
                    melalui formulir.</p>

                <div class="space-y-6">
                    @if ($school->address)
                        <div class="flex gap-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                @svg('fas-map-marker-alt', 'w-6 h-6 text-primary')
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Alamat</h3>
                                <p class="text-gray-600">{{ $school->address }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($school->phone)
                        <div class="flex gap-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                @svg('fas-phone', 'w-6 h-6 text-primary')
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Telepon</h3>
                                <p class="text-gray-600">{{ $school->phone }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($school->email)
                        <div class="flex gap-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                @svg('fas-envelope', 'w-6 h-6 text-primary')
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600">{{ $school->email }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- WhatsApp Buttons -->
                <div class="mt-8">
                    <h3 class="font-semibold text-gray-900 mb-4">Hubungi via WhatsApp</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="http://wa.me/081584455355" target="_blank"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors shadow-md">
                            @svg('fab-whatsapp', 'w-6 h-6')
                            <span>081584455355 (Abdul Hamid)</span>
                        </a>
                        <a href="http://wa.me/081294686757" target="_blank"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors shadow-md">
                            @svg('fab-whatsapp', 'w-6 h-6')
                            <span>081294686757 (Aspuri)</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Kirim Pesan</h2>

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon
                            (opsional)</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea name="message" id="message" rows="5" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">Kirim
                        Pesan</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.frontend.app>
