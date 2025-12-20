<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

/**
 * Achievement Controller for managing student/school achievements.
 */
class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::forSchool(session('school_id'))
            ->with('creator')
            ->when($request->type, fn($q, $type) => $q->type($type))
            ->when($request->year, fn($q, $year) => $q->year($year))
            ->latest()
            ->paginate(15);

        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        $types = Achievement::TYPE_LABELS;
        $levels = Achievement::LEVEL_LABELS;
        return view('admin.achievements.create', compact('types', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'level' => 'required|string',
            'rank' => 'nullable|string|max:100',
            'participant_name' => 'nullable|string|max:255',
            'participant_class' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'achievement_date' => 'nullable|date',
            'year' => 'required|integer|min:2000|max:2100',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['user_id'] = auth()->id();

        $achievement = Achievement::create($validated);

        if ($request->hasFile('image')) {
            $achievement->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.achievements.index')
            ->with('status', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement)
    {
        $this->authorizeSchool($achievement);
        $types = Achievement::TYPE_LABELS;
        $levels = Achievement::LEVEL_LABELS;
        return view('admin.achievements.edit', compact('achievement', 'types', 'levels'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $this->authorizeSchool($achievement);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'level' => 'required|string',
            'rank' => 'nullable|string|max:100',
            'participant_name' => 'nullable|string|max:255',
            'participant_class' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'achievement_date' => 'nullable|date',
            'year' => 'required|integer|min:2000|max:2100',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $achievement->update($validated);

        if ($request->hasFile('image')) {
            $achievement->clearMediaCollection('image');
            $achievement->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.achievements.index')
            ->with('status', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        $this->authorizeSchool($achievement);
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('status', 'Prestasi berhasil dihapus.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
