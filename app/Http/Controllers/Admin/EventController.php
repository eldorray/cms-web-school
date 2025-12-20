<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * Event Controller for managing academic calendar.
 */
class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::forSchool(session('school_id'))
            ->with('creator')
            ->when($request->month, function ($query, $month) use ($request) {
                $year = $request->year ?? now()->year;
                $query->inMonth($year, $month);
            })
            ->orderBy('start_date')
            ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'is_all_day' => 'boolean',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['user_id'] = auth()->id();
        $validated['is_all_day'] = $request->boolean('is_all_day');

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('status', 'Agenda berhasil dibuat.');
    }

    public function edit(Event $event)
    {
        $this->authorizeSchool($event);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeSchool($event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'is_all_day' => 'boolean',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'is_published' => 'boolean',
        ]);

        $validated['is_all_day'] = $request->boolean('is_all_day');
        $validated['is_published'] = $request->boolean('is_published');

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('status', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeSchool($event);
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('status', 'Agenda berhasil dihapus.');
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
