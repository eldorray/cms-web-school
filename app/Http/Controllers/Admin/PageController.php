<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Page Controller for managing static pages.
 */
class PageController extends Controller
{
    public function index()
    {
        $pages = Page::forSchool(session('school_id'))
            ->with('author')
            ->ordered()
            ->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $templates = Page::TEMPLATES;
        return view('admin.pages.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'template' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_in_menu'] = $request->boolean('show_in_menu');

        $page = Page::create($validated);

        if ($request->hasFile('featured_image')) {
            $page->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.pages.index')
            ->with('status', 'Halaman berhasil dibuat.');
    }

    public function edit(Page $page)
    {
        $this->authorizeSchool($page);
        $templates = Page::TEMPLATES;
        return view('admin.pages.edit', compact('page', 'templates'));
    }

    public function update(Request $request, Page $page)
    {
        $this->authorizeSchool($page);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'template' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_in_menu'] = $request->boolean('show_in_menu');

        $page->update($validated);

        if ($request->hasFile('featured_image')) {
            $page->clearMediaCollection('featured_image');
            $page->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.pages.index')
            ->with('status', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $this->authorizeSchool($page);
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('status', 'Halaman berhasil dihapus.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
