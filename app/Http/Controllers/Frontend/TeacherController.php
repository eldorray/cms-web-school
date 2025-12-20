<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $school = app('currentSchool');
        
        $teachers = Teacher::where('school_id', $school->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('position')
            ->get()
            ->groupBy('position');
        
        return view('frontend.teachers.index', compact('school', 'teachers'));
    }
    
    public function show(Teacher $teacher)
    {
        $school = app('currentSchool');
        
        abort_if($teacher->school_id !== $school->id || !$teacher->is_active, 404);
        
        return view('frontend.teachers.show', compact('school', 'teacher'));
    }
}
