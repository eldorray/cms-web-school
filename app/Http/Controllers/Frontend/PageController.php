<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page)
    {
        $school = app('currentSchool');
        
        abort_if($page->school_id !== $school->id || !$page->is_published, 404);
        
        return view('frontend.pages.show', compact('school', 'page'));
    }
}
