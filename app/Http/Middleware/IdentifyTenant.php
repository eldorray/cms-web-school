<?php

namespace App\Http\Middleware;

use App\Models\School;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to identify the current tenant (school) based on domain.
 * Sets school context in session for subsequent requests.
 */
class IdentifyTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $school = $this->identifySchool($request);

        if (!$school) {
            abort(404, 'Sekolah tidak ditemukan.');
        }

        if (!$school->is_active) {
            abort(403, 'Website sekolah ini sedang tidak aktif.');
        }

        if (!$school->isSubscriptionActive()) {
            abort(403, 'Langganan sekolah ini telah berakhir.');
        }

        // Store school in session and request
        session(['school_id' => $school->id]);
        $request->attributes->set('school', $school);

        // Bind to container so controllers can access via app('currentSchool')
        app()->instance('currentSchool', $school);

        // Share school with all views
        view()->share('currentSchool', $school);
        view()->share('school', $school);

        return $next($request);
    }

    /**
     * Identify school based on domain or request.
     */
    protected function identifySchool(Request $request): ?School
    {
        $host = $request->getHost();

        // First try to find by exact domain match
        $school = School::where('domain', $host)->first();

        if ($school) {
            return $school;
        }

        // For local development or testing, try to get from session or query param
        if (app()->environment('local', 'testing')) {
            // Check for school_slug in query param (dev only)
            if ($request->has('school')) {
                $school = School::where('slug', $request->get('school'))->first();
                if ($school) {
                    return $school;
                }
            }

            // Check session
            if (session()->has('school_id')) {
                return School::find(session('school_id'));
            }

            // Return first active school for development
            return School::where('is_active', true)->first();
        }

        return null;
    }
}
