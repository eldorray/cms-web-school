<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PpdbPeriod;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function index()
    {
        $school = app('currentSchool');
        
        $activePeriod = PpdbPeriod::where('school_id', $school->id)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->first();
        
        return view('frontend.ppdb.index', compact('school', 'activePeriod'));
    }
    
    public function create()
    {
        $school = app('currentSchool');
        
        $activePeriod = PpdbPeriod::where('school_id', $school->id)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->firstOrFail();
        
        // Check quota
        if ($activePeriod->quota) {
            $currentCount = PpdbRegistration::where('ppdb_period_id', $activePeriod->id)->count();
            if ($currentCount >= $activePeriod->quota) {
                return redirect()->route('ppdb.index')->with('error', 'Kuota pendaftaran sudah penuh.');
            }
        }
        
        return view('frontend.ppdb.create', compact('school', 'activePeriod'));
    }
    
    public function store(Request $request)
    {
        $school = app('currentSchool');
        
        $activePeriod = PpdbPeriod::where('school_id', $school->id)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->firstOrFail();
        
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'previous_school' => 'nullable|string|max:255',
            'father_name' => 'required|string|max:255',
            'father_job' => 'nullable|string|max:100',
            'mother_name' => 'required|string|max:255',
            'mother_job' => 'nullable|string|max:100',
            'parent_phone' => 'required|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'file_kk' => 'required|file|mimes:png,jpg,jpeg,pdf|max:2048',
            'file_akta' => 'required|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);
        
        // Handle file uploads
        $documents = [];
        if ($request->hasFile('file_kk')) {
            $documents['kk'] = $request->file('file_kk')->store('ppdb/documents', 'public');
        }
        if ($request->hasFile('file_akta')) {
            $documents['akta'] = $request->file('file_akta')->store('ppdb/documents', 'public');
        }
        
        // Generate registration number
        $year = now()->format('Y');
        $count = PpdbRegistration::where('school_id', $school->id)
            ->whereYear('created_at', $year)
            ->count() + 1;
        $registrationNumber = "PPDB-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
        
        // Map form fields to database columns
        $parentName = $validated['father_name'] . ' / ' . $validated['mother_name'];
        $parentOccupation = trim(($validated['father_job'] ?? '') . ' / ' . ($validated['mother_job'] ?? ''), ' /');
        
        $registration = PpdbRegistration::create([
            'school_id' => $school->id,
            'ppdb_period_id' => $activePeriod->id,
            'registration_number' => $registrationNumber,
            'status' => 'pending',
            'student_name' => $validated['student_name'],
            'nisn' => $validated['nisn'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'religion' => $validated['religion'],
            'address' => $validated['address'],
            'previous_school' => $validated['previous_school'],
            'parent_name' => $parentName,
            'parent_phone' => $validated['parent_phone'],
            'parent_email' => $validated['parent_email'],
            'parent_occupation' => $parentOccupation ?: null,
            'documents' => $documents,
        ]);
        
        return redirect()->route('ppdb.status', ['no' => $registrationNumber])
            ->with('success', 'Pendaftaran berhasil! Simpan nomor pendaftaran Anda.');
    }
    
    public function status(Request $request)
    {
        $school = app('currentSchool');
        
        $registration = null;
        if ($request->no) {
            $registration = PpdbRegistration::where('school_id', $school->id)
                ->where('registration_number', $request->no)
                ->first();
        }
        
        return view('frontend.ppdb.status', compact('school', 'registration'));
    }
}
