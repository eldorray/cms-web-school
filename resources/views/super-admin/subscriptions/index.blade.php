<x-layouts.super-admin header="Kelola Langganan">
    <div class="flex gap-2 mb-6">
        <a href="{{ route('super-admin.subscriptions.index') }}"
            class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">Semua</a>
        <a href="{{ route('super-admin.subscriptions.index', ['status' => 'active']) }}"
            class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'active' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">Aktif</a>
        <a href="{{ route('super-admin.subscriptions.index', ['status' => 'expired']) }}"
            class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'expired' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">Kadaluarsa</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sekolah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berlaku Hingga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $planLabels = [
                        'free' => 'Gratis',
                        'basic' => 'Basic',
                        'pro' => 'Pro',
                        'enterprise' => 'Enterprise',
                    ];
                @endphp
                @forelse($schools as $school)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $school->name }}</p>
                            <p class="text-sm text-gray-500">{{ $school->domain }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $planLabels[$school->subscription?->plan ?? 'free'] ?? 'Gratis' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $school->subscription?->expires_at?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if (!$school->subscription || $school->subscription->expires_at <= now())
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Kadaluarsa</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super-admin.subscriptions.edit', $school) }}"
                                    class="p-2 text-gray-500 hover:text-blue-600">@svg('fas-pen', 'w-4 h-4')</a>
                                <form method="POST" action="{{ route('super-admin.subscriptions.renew', $school) }}"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-500 hover:text-green-600"
                                        title="Perpanjang 1 Tahun">@svg('fas-sync', 'w-4 h-4')</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($schools->hasPages())
            <div class="px-6 py-4 border-t">{{ $schools->links() }}</div>
        @endif
    </div>
</x-layouts.super-admin>
