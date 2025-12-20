<x-layouts.super-admin :header="'Edit Langganan: ' . $school->name">
    <form method="POST" action="{{ route('super-admin.subscriptions.update', $school) }}" class="max-w-xl">
        @csrf @method('PUT')
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Paket Langganan</label>
                <select name="plan" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @foreach ($plans as $key => $label)
                        <option value="{{ $key }}"
                            {{ ($school->subscription?->plan ?? 'free') == $key ? 'selected' : '' }}>{{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Hingga</label>
                <input type="date" name="expires_at"
                    value="{{ old('expires_at', $school->subscription?->expires_at?->format('Y-m-d') ?? now()->addYear()->format('Y-m-d')) }}"
                    required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('super-admin.subscriptions.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
            </div>
        </div>
    </form>
</x-layouts.super-admin>
