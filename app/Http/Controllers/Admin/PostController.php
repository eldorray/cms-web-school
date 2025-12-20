<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Post Controller for managing news/announcements.
 */
class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $schoolId = session('school_id');

        $posts = Post::forSchool($schoolId)
            ->with('author', 'category')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->status, function ($query, $status) {
                if ($status === 'published') {
                    $query->where('is_published', true);
                } elseif ($status === 'draft') {
                    $query->where('is_published', false);
                }
            })
            ->latest()
            ->paginate(15);

        $categories = Category::forSchool($schoolId)->active()->ordered()->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $schoolId = session('school_id');
        $categories = Category::forSchool($schoolId)->active()->ordered()->get();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_pinned'] = $request->boolean('is_pinned');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.posts.index')
            ->with('status', 'Berita berhasil dibuat.');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        $this->authorizeSchool($post);

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $this->authorizeSchool($post);

        $schoolId = session('school_id');
        $categories = Category::forSchool($schoolId)->active()->ordered()->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizeSchool($post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_pinned'] = $request->boolean('is_pinned');

        if ($validated['is_published'] && !$post->is_published) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured_image');
            $post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.posts.index')
            ->with('status', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post)
    {
        $this->authorizeSchool($post);

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(Post $post)
    {
        $this->authorizeSchool($post);

        $post->update([
            'is_published' => !$post->is_published,
            'published_at' => !$post->is_published ? now() : $post->published_at,
        ]);

        $status = $post->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('status', "Berita berhasil {$status}.");
    }

    /**
     * Toggle pin status.
     */
    public function togglePin(Post $post)
    {
        $this->authorizeSchool($post);

        $post->update(['is_pinned' => !$post->is_pinned]);

        $status = $post->is_pinned ? 'disematkan' : 'tidak disematkan';

        return back()->with('status', "Berita berhasil {$status}.");
    }

    /**
     * Authorize that the model belongs to the current school.
     */
    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
