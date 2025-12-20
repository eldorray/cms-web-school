<x-layouts.frontend.app :school="$school" :title="'Formulir PPDB - ' . $school->name">
    <div class="bg-white min-h-screen">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-2xl mx-auto">
                <nav class="text-sm text-gray-600 mb-6">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('ppdb.index') }}" class="hover:text-blue-600">PPDB</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-800">Formulir Pendaftaran</span>
                </nav>

                <h1 class="text-3xl font-bold text-gray-800 mb-2">Formulir Pendaftaran</h1>
                <p class="text-gray-600 mb-8">{{ $activePeriod->name }} - TA {{ $activePeriod->academic_year }}</p>

                <form method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Data Siswa -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Siswa</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="student_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap *</label>
                                <input type="text" name="student_name" id="student_name"
                                    value="{{ old('student_name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white text-gray-800">
                                @error('student_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat
                                    Lahir *</label>
                                <input type="text" name="birth_place" id="birth_place"
                                    value="{{ old('birth_place') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                    Lahir *</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin
                                    *</label>
                                <select name="gender" id="gender" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama
                                    *</label>
                                <select name="religion" id="religion" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                                    <option value="">Pilih</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $r)
                                        <option value="{{ $r }}"
                                            {{ old('religion') == $r ? 'selected' : '' }}>
                                            {{ $r }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat
                                    *</label>
                                <textarea name="address" id="address" rows="2" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">{{ old('address') }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label for="previous_school" class="block text-sm font-medium text-gray-700 mb-2">Asal
                                    Sekolah</label>
                                <input type="text" name="previous_school" id="previous_school"
                                    value="{{ old('previous_school') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Orang Tua</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah
                                    *</label>
                                <input type="text" name="father_name" id="father_name"
                                    value="{{ old('father_name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="father_job" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan
                                    Ayah</label>
                                <input type="text" name="father_job" id="father_job"
                                    value="{{ old('father_job') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu
                                    *</label>
                                <input type="text" name="mother_name" id="mother_name"
                                    value="{{ old('mother_name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="mother_job" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan
                                    Ibu</label>
                                <input type="text" name="mother_job" id="mother_job"
                                    value="{{ old('mother_job') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">No.
                                    Telepon *</label>
                                <input type="text" name="parent_phone" id="parent_phone"
                                    value="{{ old('parent_phone') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                            <div>
                                <label for="parent_email"
                                    class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="parent_email" id="parent_email"
                                    value="{{ old('parent_email') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-800">
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Dokumen</h2>
                        <p class="text-sm text-gray-600 mb-4">Format yang diperbolehkan: PNG, JPG, JPEG, PDF. Maksimal
                            2MB per file.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="file_kk" class="block text-sm font-medium text-gray-700 mb-2">Kartu
                                    Keluarga (KK) *</label>
                                <input type="file" name="file_kk" id="file_kk" required
                                    accept=".png,.jpg,.jpeg,.pdf"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                @error('file_kk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="file_akta" class="block text-sm font-medium text-gray-700 mb-2">Akta
                                    Kelahiran *</label>
                                <input type="file" name="file_akta" id="file_akta" required
                                    accept=".png,.jpg,.jpeg,.pdf"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                @error('file_akta')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-colors">Kirim
                        Pendaftaran</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.frontend.app>
