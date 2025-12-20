<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

/**
 * Download Controller for managing downloadable files.
 */
class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $downloads = Download::forSchool(session('school_id'))
            ->with('uploader')
            ->when($request->category, fn($q, $cat) => $q->category($cat))
            ->ordered()
            ->paginate(15);

        $categories = Download::CATEGORY_LABELS;

        return view('admin.downloads.index', compact('downloads', 'categories'));
    }

    public function create()
    {
        $categories = Download::CATEGORY_LABELS;
        return view('admin.downloads.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $validated['school_id'] = session('school_id');
        $validated['user_id'] = auth()->id();
        $validated['file_name'] = $file->getClientOriginalName();
        $validated['file_type'] = $file->getMimeType();
        $validated['file_size'] = $file->getSize();
        $validated['file_path'] = $file->store('downloads', 'public');

        Download::create($validated);

        return redirect()->route('admin.downloads.index')
            ->with('status', 'File berhasil diunggah.');
    }

    public function edit(Download $download)
    {
        $this->authorizeSchool($download);
        $categories = Download::CATEGORY_LABELS;
        return view('admin.downloads.edit', compact('download', 'categories'));
    }

    public function update(Request $request, Download $download)
    {
        $this->authorizeSchool($download);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'file' => 'nullable|file|max:10240',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getMimeType();
            $validated['file_size'] = $file->getSize();
            $validated['file_path'] = $file->store('downloads', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $download->update($validated);

        return redirect()->route('admin.downloads.index')
            ->with('status', 'File berhasil diperbarui.');
    }

    public function destroy(Download $download)
    {
        $this->authorizeSchool($download);
        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('status', 'File berhasil dihapus.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
