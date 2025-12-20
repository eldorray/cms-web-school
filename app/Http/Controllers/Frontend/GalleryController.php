<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $school = app('currentSchool');
        
        $galleries = Gallery::where('school_id', $school->id)
            ->where('is_published', true)
            ->withCount('items')
            ->latest()
            ->paginate(12);
        
        return view('frontend.galleries.index', compact('school', 'galleries'));
    }
    
    public function show(Gallery $gallery)
    {
        $school = app('currentSchool');
        
        abort_if($gallery->school_id !== $school->id || !$gallery->is_published, 404);
        
        $gallery->load('items');
        
        return view('frontend.galleries.show', compact('school', 'gallery'));
    }
}
