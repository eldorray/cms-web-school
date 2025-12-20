<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

/**
 * Teacher Controller for managing school personnel.
 */
class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::forSchool(session('school_id'))
            ->when($request->position, fn($q, $pos) => $q->position($pos))
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->ordered()
            ->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $positions = Teacher::POSITION_LABELS;
        return view('admin.teachers.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nuptk' => 'nullable|string|max:50',
            'position' => 'required|string',
            'position_detail' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['school_id'] = session('school_id');

        $teacher = Teacher::create($validated);

        if ($request->hasFile('photo')) {
            $teacher->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        return redirect()->route('admin.teachers.index')
            ->with('status', 'Data guru/staff berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        $this->authorizeSchool($teacher);
        $positions = Teacher::POSITION_LABELS;
        return view('admin.teachers.edit', compact('teacher', 'positions'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $this->authorizeSchool($teacher);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nuptk' => 'nullable|string|max:50',
            'position' => 'required|string',
            'position_detail' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $teacher->update($validated);

        if ($request->hasFile('photo')) {
            $teacher->clearMediaCollection('photo');
            $teacher->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        return redirect()->route('admin.teachers.index')
            ->with('status', 'Data guru/staff berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        $this->authorizeSchool($teacher);
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('status', 'Data guru/staff berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        foreach ($request->items as $index => $id) {
            Teacher::where('id', $id)
                ->where('school_id', session('school_id'))
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
