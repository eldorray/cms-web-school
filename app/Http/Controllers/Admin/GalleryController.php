<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Gallery Controller for managing photo/video albums.
 */
class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::forSchool(session('school_id'))
            ->withCount('items')
            ->ordered()
            ->paginate(12);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'cover' => 'nullable|image|max:2048',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        $gallery = Gallery::create($validated);

        if ($request->hasFile('cover')) {
            $gallery->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return redirect()->route('admin.galleries.edit', $gallery)
            ->with('status', 'Galeri berhasil dibuat. Tambahkan foto/video.');
    }

    public function edit(Gallery $gallery)
    {
        $this->authorizeSchool($gallery);
        $gallery->load('items');
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->authorizeSchool($gallery);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'cover' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');

        $gallery->update($validated);

        if ($request->hasFile('cover')) {
            $gallery->clearMediaCollection('cover');
            $gallery->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return back()->with('status', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->authorizeSchool($gallery);
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('status', 'Galeri berhasil dihapus.');
    }

    public function storeItem(Request $request, Gallery $gallery)
    {
        $this->authorizeSchool($gallery);

        $validated = $request->validate([
            'type' => 'required|in:image,video',
            'file' => 'required_if:type,image|image|max:5120',
            'video_url' => 'required_if:type,video|nullable|url',
            'caption' => 'nullable|string|max:255',
        ]);

        $item = $gallery->items()->create([
            'type' => $validated['type'],
            'file_path' => '',
            'caption' => $validated['caption'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'order' => $gallery->items()->count(),
        ]);

        if ($request->hasFile('file')) {
            $item->addMediaFromRequest('file')->toMediaCollection('file');
        }

        return back()->with('status', 'Item berhasil ditambahkan.');
    }

    public function destroyItem(Gallery $gallery, GalleryItem $item)
    {
        $this->authorizeSchool($gallery);
        
        if ($item->gallery_id !== $gallery->id) {
            abort(403);
        }

        $item->delete();

        return back()->with('status', 'Item berhasil dihapus.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
