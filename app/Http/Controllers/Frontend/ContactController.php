<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $school = app('currentSchool');
        
        return view('frontend.contact.index', compact('school'));
    }
    
    public function store(Request $request)
    {
        $school = app('currentSchool');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);
        
        ContactMessage::create([
            'school_id' => $school->id,
            ...$validated,
        ]);
        
        return back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }
}
