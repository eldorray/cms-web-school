<x-layouts.frontend.app :school="$school" :title="$page->title . ' - ' . $school->name">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <nav class="text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
                <span class="mx-2">/</span>
                <span>{{ $page->title }}</span>
            </nav>

            @if ($page->getFirstMediaUrl('featured_image'))
                <div class="aspect-video rounded-xl overflow-hidden mb-8">
                    <img src="{{ $page->getFirstMediaUrl('featured_image') }}" alt="{{ $page->title }}"
                        class="w-full h-full object-cover">
                </div>
            @endif

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">{{ $page->title }}</h1>

            <div class="prose prose-lg max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-layouts.frontend.app>
