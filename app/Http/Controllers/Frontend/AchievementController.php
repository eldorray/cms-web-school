<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $school = app('currentSchool');
        
        $achievements = Achievement::where('school_id', $school->id)
            ->where('is_published', true)
            ->when($request->year, fn($q, $year) => $q->where('year', $year))
            ->when($request->type, fn($q, $type) => $q->where('type', $type))
            ->when($request->level, fn($q, $level) => $q->where('level', $level))
            ->latest('year')
            ->latest('achievement_date')
            ->paginate(12);
        
        $years = Achievement::where('school_id', $school->id)
            ->where('is_published', true)
            ->distinct()
            ->pluck('year')
            ->sort()
            ->reverse();
        
        return view('frontend.achievements.index', compact('school', 'achievements', 'years'));
    }
}
