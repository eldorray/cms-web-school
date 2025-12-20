<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Achievement;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $school = app('currentSchool');
        
        // Latest posts
        $posts = Post::where('school_id', $school->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(6)
            ->get();
        
        // Upcoming events
        $events = Event::where('school_id', $school->id)
            ->where('is_published', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();
        
        // Featured teachers (all active teachers)
        $teachers = Teacher::where('school_id', $school->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->take(4)
            ->get();
        
        // Latest achievements
        $achievements = Achievement::where('school_id', $school->id)
            ->where('is_published', true)
            ->latest('year')
            ->take(6)
            ->get();
        
        // Latest gallery
        $galleries = Gallery::where('school_id', $school->id)
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();
        
        return view('frontend.home', compact(
            'school',
            'posts',
            'events',
            'teachers',
            'achievements',
            'galleries'
        ));
    }
}
