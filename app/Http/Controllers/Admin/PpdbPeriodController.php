<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbPeriod;
use Illuminate\Http\Request;

class PpdbPeriodController extends Controller
{
    public function index()
    {
        $periods = PpdbPeriod::forSchool(session('school_id'))
            ->withCount('registrations')
            ->latest()
            ->paginate(15);

        return view('admin.ppdb-periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.ppdb-periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'requirements' => 'nullable|string',
            'description' => 'nullable|string',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['is_active'] = $request->boolean('is_active');

        PpdbPeriod::create($validated);

        return redirect()->route('admin.ppdb-periods.index')
            ->with('status', 'Periode PPDB berhasil dibuat.');
    }

    public function edit(PpdbPeriod $ppdbPeriod)
    {
        $this->authorizeSchool($ppdbPeriod);
        return view('admin.ppdb-periods.edit', compact('ppdbPeriod'));
    }

    public function update(Request $request, PpdbPeriod $ppdbPeriod)
    {
        $this->authorizeSchool($ppdbPeriod);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'requirements' => 'nullable|string',
            'description' => 'nullable|string',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $ppdbPeriod->update($validated);

        return redirect()->route('admin.ppdb-periods.index')
            ->with('status', 'Periode PPDB berhasil diperbarui.');
    }

    public function destroy(PpdbPeriod $ppdbPeriod)
    {
        $this->authorizeSchool($ppdbPeriod);
        $ppdbPeriod->delete();

        return redirect()->route('admin.ppdb-periods.index')
            ->with('status', 'Periode PPDB berhasil dihapus.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
