<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $school = app('currentSchool');
        
        $downloads = Download::where('school_id', $school->id)
            ->where('is_published', true)
            ->when($request->category, fn($q, $cat) => $q->where('category', $cat))
            ->latest()
            ->paginate(20);
        
        $categories = Download::where('school_id', $school->id)
            ->where('is_published', true)
            ->distinct()
            ->pluck('category');
        
        return view('frontend.downloads.index', compact('school', 'downloads', 'categories'));
    }
    
    public function download(Download $download)
    {
        $school = app('currentSchool');
        
        abort_if($download->school_id !== $school->id || !$download->is_published, 404);
        
        $download->increment('download_count');
        
        // Check if file exists in storage
        if (!$download->file_path || !Storage::disk('public')->exists($download->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        
        $filePath = Storage::disk('public')->path($download->file_path);
        $fileName = $download->file_name ?? basename($download->file_path);
        
        return response()->download($filePath, $fileName);
    }
}
