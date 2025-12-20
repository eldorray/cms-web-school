<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Post;
use App\Models\PpdbRegistration;
use App\Models\Teacher;
use Illuminate\Http\Request;

/**
 * Admin Dashboard Controller.
 * Displays overview statistics and recent activity for the school.
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        $schoolId = session('school_id');

        // Statistics
        $stats = [
            'posts' => Post::forSchool($schoolId)->count(),
            'published_posts' => Post::forSchool($schoolId)->published()->count(),
            'events' => Event::forSchool($schoolId)->upcoming()->count(),
            'teachers' => Teacher::forSchool($schoolId)->active()->count(),
            'unread_messages' => ContactMessage::forSchool($schoolId)->unread()->count(),
            'pending_registrations' => PpdbRegistration::forSchool($schoolId)->pending()->count(),
        ];

        // Recent posts
        $recentPosts = Post::forSchool($schoolId)
            ->with('author', 'category')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming events
        $upcomingEvents = Event::forSchool($schoolId)
            ->published()
            ->upcoming()
            ->take(5)
            ->get();

        // Recent registrations
        $recentRegistrations = PpdbRegistration::forSchool($schoolId)
            ->with('period')
            ->latest()
            ->take(5)
            ->get();

        // Recent messages
        $recentMessages = ContactMessage::forSchool($schoolId)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'upcomingEvents',
            'recentRegistrations',
            'recentMessages'
        ));
    }
}
