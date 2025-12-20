<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['school', 'roles'])
            ->when($request->search, fn($q, $search) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
            ->when($request->school, fn($q, $schoolId) => $q->where('school_id', $schoolId))
            ->when($request->role, fn($q, $role) => $q->role($role))
            ->latest()
            ->paginate(15);
        
        $schools = School::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        
        return view('super-admin.users.index', compact('users', 'schools', 'roles'));
    }
    
    public function create()
    {
        $schools = School::where('is_active', true)->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        
        return view('super-admin.users.create', compact('schools', 'roles'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'school_id' => 'nullable|exists:schools,id',
            'role' => 'required|exists:roles,name',
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'school_id' => $validated['school_id'],
            'is_active' => true,
        ]);
        
        $user->assignRole($validated['role']);
        
        return redirect()->route('super-admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }
    
    public function edit(User $user)
    {
        $schools = School::where('is_active', true)->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        
        return view('super-admin.users.edit', compact('user', 'schools', 'roles'));
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'school_id' => 'nullable|exists:schools,id',
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'school_id' => $validated['school_id'],
            'is_active' => $request->boolean('is_active'),
        ]);
        
        if ($validated['password']) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }
        
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('super-admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }
    
    public function destroy(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'Tidak dapat menghapus super admin.');
        }
        
        $user->delete();
        
        return redirect()->route('super-admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
