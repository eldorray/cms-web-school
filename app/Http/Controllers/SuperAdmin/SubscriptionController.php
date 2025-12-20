<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::with('subscription')
            ->when($request->status, function($q, $status) {
                if ($status === 'active') {
                    $q->whereHas('subscription', fn($s) => $s->where('expires_at', '>', now()));
                } elseif ($status === 'expired') {
                    $q->whereHas('subscription', fn($s) => $s->where('expires_at', '<=', now()));
                }
            })
            ->orderByDesc('created_at')
            ->paginate(15);
        
        return view('super-admin.subscriptions.index', compact('schools'));
    }
    
    public function show(School $subscription)
    {
        $school = $subscription;
        $school->load('subscription');
        
        return view('super-admin.subscriptions.show', compact('school'));
    }
    
    public function edit(School $subscription)
    {
        $school = $subscription;
        $plans = [
            'free' => 'Gratis',
            'basic' => 'Basic',
            'pro' => 'Professional',
            'enterprise' => 'Enterprise',
        ];
        
        return view('super-admin.subscriptions.edit', compact('school', 'plans'));
    }
    
    public function update(Request $request, School $subscription)
    {
        $school = $subscription;
        
        $validated = $request->validate([
            'plan' => 'required|in:free,basic,pro,enterprise',
            'expires_at' => 'required|date|after:today',
        ]);
        
        $school->subscription()->updateOrCreate(
            ['school_id' => $school->id],
            [
                'plan' => $validated['plan'],
                'expires_at' => $validated['expires_at'],
                'is_active' => true,
            ]
        );
        
        return redirect()->route('super-admin.subscriptions.index')
            ->with('success', 'Langganan berhasil diperbarui.');
    }
    
    public function renew(School $subscription)
    {
        $school = $subscription;
        
        $school->subscription()->update([
            'expires_at' => now()->addYear(),
        ]);
        
        return back()->with('success', 'Langganan berhasil diperpanjang 1 tahun.');
    }
}
