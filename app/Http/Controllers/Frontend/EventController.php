<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $school = app('currentSchool');
        
        $upcomingEvents = Event::where('school_id', $school->id)
            ->where('is_published', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->get();
        
        $pastEvents = Event::where('school_id', $school->id)
            ->where('is_published', true)
            ->where('start_date', '<', now())
            ->orderByDesc('start_date')
            ->paginate(12);
        
        return view('frontend.events.index', compact('school', 'upcomingEvents', 'pastEvents'));
    }
    
    public function show(Event $event)
    {
        $school = app('currentSchool');
        
        abort_if($event->school_id !== $school->id || !$event->is_published, 404);
        
        return view('frontend.events.show', compact('school', 'event'));
    }
}
