<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('admin.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|unique:team_members,email|max:255',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team', 'public');
        }

        TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'description' => $request->description,
            'image' => $imagePath,
            'email' => $request->email,
            'phone' => $request->phone,
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully!');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|unique:team_members,email,' . $team->id . '|max:255',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        $data = $request->only(['name', 'role', 'description', 'email', 'phone', 'linkedin', 'twitter']);

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }

        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully!');
    }
}
