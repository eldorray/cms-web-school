<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbPeriod;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class PpdbRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = session('school_id');

        $registrations = PpdbRegistration::forSchool($schoolId)
            ->with('period')
            ->when($request->period, fn($q, $id) => $q->where('ppdb_period_id', $id))
            ->when($request->status, fn($q, $s) => $q->status($s))
            ->when($request->search, fn($q, $s) => $q->where('student_name', 'like', "%{$s}%"))
            ->latest()
            ->paginate(15);

        $periods = PpdbPeriod::forSchool($schoolId)->get();
        $statuses = PpdbRegistration::STATUS_LABELS;

        return view('admin.ppdb-registrations.index', compact('registrations', 'periods', 'statuses'));
    }

    public function show(PpdbRegistration $ppdbRegistration)
    {
        $this->authorizeSchool($ppdbRegistration);
        $ppdbRegistration->load('period');

        return view('admin.ppdb-registrations.show', compact('ppdbRegistration'));
    }

    public function edit(PpdbRegistration $ppdbRegistration)
    {
        $this->authorizeSchool($ppdbRegistration);
        $statuses = PpdbRegistration::STATUS_LABELS;

        return view('admin.ppdb-registrations.edit', compact('ppdbRegistration', 'statuses'));
    }

    public function update(Request $request, PpdbRegistration $ppdbRegistration)
    {
        $this->authorizeSchool($ppdbRegistration);

        $validated = $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'verified' && $ppdbRegistration->status !== 'verified') {
            $validated['verified_at'] = now();
        }

        $ppdbRegistration->update($validated);

        return redirect()->route('admin.ppdb-registrations.index')
            ->with('status', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy(PpdbRegistration $ppdbRegistration)
    {
        $this->authorizeSchool($ppdbRegistration);
        $ppdbRegistration->delete();

        return redirect()->route('admin.ppdb-registrations.index')
            ->with('status', 'Pendaftaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, PpdbRegistration $registration)
    {
        $this->authorizeSchool($registration);

        $request->validate(['status' => 'required|string']);

        $registration->update([
            'status' => $request->status,
            'verified_at' => $request->status === 'verified' ? now() : $registration->verified_at,
        ]);

        return back()->with('status', 'Status berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        // Export functionality - placeholder for CSV/Excel export
        return back()->with('status', 'Fitur export sedang dikembangkan.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
