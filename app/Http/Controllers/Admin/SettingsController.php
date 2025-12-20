<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $school = School::find(session('school_id'));
        $settings = Setting::forSchool(session('school_id'))->get()->keyBy('key');

        return view('admin.settings.index', compact('school', 'settings'));
    }

    public function update(Request $request)
    {
        $school = School::find(session('school_id'));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'theme_primary_color' => 'nullable|string|max:7',
            'theme_secondary_color' => 'nullable|string|max:7',
            'theme_accent_color' => 'nullable|string|max:7',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        $school->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'theme_primary_color' => $validated['theme_primary_color'] ?? $school->theme_primary_color,
            'theme_secondary_color' => $validated['theme_secondary_color'] ?? $school->theme_secondary_color,
            'theme_accent_color' => $validated['theme_accent_color'] ?? $school->theme_accent_color,
            'social_media' => [
                'facebook' => $validated['facebook'] ?? null,
                'instagram' => $validated['instagram'] ?? null,
                'youtube' => $validated['youtube'] ?? null,
                'twitter' => $validated['twitter'] ?? null,
            ],
        ]);

        return back()->with('status', 'Pengaturan berhasil disimpan.');
    }

    public function updateLogo(Request $request)
    {
        $request->validate(['logo' => 'required|image|max:2048']);

        $school = School::find(session('school_id'));
        $school->clearMediaCollection('logo');
        $school->addMediaFromRequest('logo')->toMediaCollection('logo');

        return back()->with('status', 'Logo berhasil diperbarui.');
    }

    public function updateBanner(Request $request)
    {
        $request->validate(['banner' => 'required|image|max:5120']);

        $school = School::find(session('school_id'));
        $school->clearMediaCollection('banner');
        $school->addMediaFromRequest('banner')->toMediaCollection('banner');

        return back()->with('status', 'Banner homepage berhasil diperbarui.');
    }
}
