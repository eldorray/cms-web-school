<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'platform_name' => Cache::get('platform_name', 'CMS Web Sekolah'),
            'platform_tagline' => Cache::get('platform_tagline', 'Platform Website Sekolah Terbaik'),
            'platform_email' => Cache::get('platform_email', ''),
            'maintenance_mode' => Cache::get('maintenance_mode', false),
            'allow_registration' => Cache::get('allow_registration', true),
            'default_theme' => Cache::get('default_theme', 'blue'),
        ];
        
        return view('super-admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
            'platform_tagline' => 'nullable|string|max:255',
            'platform_email' => 'nullable|email|max:255',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'default_theme' => 'required|in:blue,green,red,purple,orange',
        ]);
        
        foreach ($validated as $key => $value) {
            Cache::forever($key, $value);
        }
        
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
