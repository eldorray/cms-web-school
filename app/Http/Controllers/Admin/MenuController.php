<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->get('location', 'header');

        $menus = Menu::getTree(session('school_id'), $location);
        $locations = Menu::LOCATION_LABELS;

        return view('admin.menus.index', compact('menus', 'locations', 'location'));
    }

    public function create()
    {
        $schoolId = session('school_id');
        $locations = Menu::LOCATION_LABELS;
        $parentMenus = Menu::forSchool($schoolId)->root()->ordered()->get();

        return view('admin.menus.create', compact('locations', 'parentMenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'target' => 'required|string|in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'location' => 'required|string',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        $validated['school_id'] = session('school_id');
        $validated['order'] = Menu::forSchool(session('school_id'))
            ->where('location', $validated['location'])
            ->max('order') + 1;

        Menu::create($validated);

        return redirect()->route('admin.menus.index', ['location' => $validated['location']])
            ->with('status', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $this->authorizeSchool($menu);
        $locations = Menu::LOCATION_LABELS;
        $parentMenus = Menu::forSchool(session('school_id'))
            ->root()
            ->where('id', '!=', $menu->id)
            ->ordered()
            ->get();

        return view('admin.menus.edit', compact('menu', 'locations', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorizeSchool($menu);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'target' => 'required|string|in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'location' => 'required|string',
            'parent_id' => 'nullable|exists:menus,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $menu->update($validated);

        return redirect()->route('admin.menus.index', ['location' => $menu->location])
            ->with('status', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $this->authorizeSchool($menu);
        $location = $menu->location;
        $menu->delete();

        return redirect()->route('admin.menus.index', ['location' => $location])
            ->with('status', 'Menu berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        foreach ($request->items as $index => $id) {
            Menu::where('id', $id)
                ->where('school_id', session('school_id'))
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
