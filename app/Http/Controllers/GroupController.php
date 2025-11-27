<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('groups', [
            'groups' => Group::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('group_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        Group::create([
            'admin_id' => 1, //Auth::id()
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_private' => $request->boolean('private'),
        ]);

        return redirect()->route('group.index')->with('success', 'Группа успешно создана.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('group', [
            'group' => Group::all()->where('id', $id)->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = Group::all()->where('id', $id)->first();
        return view('group_edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::all()->where('id', $id)->first();
        $validated = $request->validate([
            'description' => 'required|max:255'
        ]);
        $group->update([
            'description' => $validated['description'],
            'is_private' => $request->boolean('private'),
        ]);

        return redirect()->route('group.index')->with('success', 'Группа обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::all()->where('id', $id)->first();
        $group->delete();
        return redirect()->route('group.index')->with('success', 'Группа успешно удалена.');
    }
}
