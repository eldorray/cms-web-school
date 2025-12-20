<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::withCount(['users', 'posts'])
            ->when($request->search, fn($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->when($request->status !== null, fn($q) => $q->where('is_active', $request->status))
            ->latest()
            ->paginate(15);
        
        return view('super-admin.schools.index', compact('schools'));
    }
    
    public function create()
    {
        return view('super-admin.schools.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:schools,domain',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'tagline' => 'nullable|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);
        
        // Create school
        $school = School::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'domain' => $validated['domain'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'tagline' => $validated['tagline'] ?? null,
            'is_active' => true,
        ]);
        
        // Create admin user for the school
        $admin = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'school_id' => $school->id,
            'is_active' => true,
        ]);
        
        $admin->assignRole('admin');
        
        return redirect()->route('super-admin.schools.index')
            ->with('success', 'Sekolah berhasil ditambahkan.');
    }
    
    public function show(School $school)
    {
        $school->loadCount(['users', 'posts', 'events', 'teachers', 'galleries']);
        $admins = $school->users()->role('admin')->get();
        
        return view('super-admin.schools.show', compact('school', 'admins'));
    }
    
    public function edit(School $school)
    {
        return view('super-admin.schools.edit', compact('school'));
    }
    
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:schools,domain,' . $school->id,
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'tagline' => 'nullable|string|max:255',
        ]);
        
        $school->update($validated);
        
        return redirect()->route('super-admin.schools.index')
            ->with('success', 'Data sekolah berhasil diperbarui.');
    }
    
    public function destroy(School $school)
    {
        // Soft delete or prevent if has data
        if ($school->users()->count() > 1) {
            return back()->with('error', 'Tidak dapat menghapus sekolah yang memiliki pengguna.');
        }
        
        $school->delete();
        
        return redirect()->route('super-admin.schools.index')
            ->with('success', 'Sekolah berhasil dihapus.');
    }
    
    public function toggleStatus(School $school)
    {
        $school->update(['is_active' => !$school->is_active]);
        
        return back()->with('success', 'Status sekolah berhasil diperbarui.');
    }
    
    public function impersonate(School $school)
    {
        // Find admin of the school
        $admin = $school->users()->role('admin')->first();
        
        if (!$admin) {
            return back()->with('error', 'Sekolah tidak memiliki admin.');
        }
        
        // Store original user ID
        session(['impersonating_from' => Auth::id()]);
        
        // Login as school admin
        Auth::login($admin);
        
        return redirect()->route('admin.dashboard')
            ->with('info', 'Anda sekarang masuk sebagai admin sekolah.');
    }
}
