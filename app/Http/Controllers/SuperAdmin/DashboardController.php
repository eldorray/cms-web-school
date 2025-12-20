<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Models\Post;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_schools' => School::count(),
            'active_schools' => School::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_ppdb' => PpdbRegistration::count(),
        ];
        
        $recentSchools = School::latest()->take(5)->get();
        $recentUsers = User::with('school')->latest()->take(5)->get();
        
        return view('super-admin.dashboard', compact('stats', 'recentSchools', 'recentUsers'));
    }
}
