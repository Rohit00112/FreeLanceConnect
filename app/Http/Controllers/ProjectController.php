<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    // Fetch all projects for the authenticated user
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    // Store a new project with multiple images
    public function store(Request $request)
    {
        $request->validate([
             'name'        => 'required|string|max:255',
             'description' => 'required|string',
             'images'      => 'nullable|array',
             'images.*'    => 'image|max:1024',
        ], [], ['images.*' => 'image']);

        // Store the project in the database
        $project = Project::query()->create([
             'name'        => $request->name,
             'description' => $request->description,
             'user_id'     => Auth::id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('projects', 'public');
                ProjectImage::query()->create([
                     'project_id' => $project->id,
                     'image'      => $imagePath,
                ]);
            }
        }

        return redirect()->route('projects.index')->with('toast.success', 'Project created successfully!');
    }

    // Show the edit form (only for the authenticated user's project)
    public function edit($id)
    {
        $project = Project::query()->where('id', $id)
            ->where('user_id', Auth::id())
            ->with('images') // Load related images
            ->firstOrFail();

        return view('projects.edit', compact('project'));
    }

    // Update a project with multiple images
    public function update(Request $request, $id)
    {
         $request->validate([
              'name'             => 'required|string|max:255',
              'description'      => 'required|string',
              'images'           => 'nullable|array',
              'images.*'         => 'image|max:1024',
              'removed_images'   => ['nullable', 'array'],
         ], [], ['images.*' => 'image']);

        $project = Project::query()->with('images')->findOrFail($id);
        $project->update([
             'name'        => $request->input('name'),
             'description' => $request->input('description'),
        ]);

        if(!empty($request->input('removed_images'))) {
             $images = ProjectImage::query()->whereIn('id', $request->input('removed_images'))->get();
             foreach ($images as $image) {
                  Storage::disk('public')->delete($image->image);
                  $image->delete();
             }
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('projects', 'public');
                 ProjectImage::query()->create([
                      'project_id' => $project->id,
                      'image'      => $imagePath,
                 ]);
            }
        }
        return redirect()->route('projects.index')->with('toast.success', 'Project updated successfully!');
    }

    // Delete a project (only if it belongs to the authenticated user)
    public function destroy($id)
    {
        $project = Project::query()->with('images')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        foreach ($project->images as $projectImage) {
            Storage::disk('public')->delete($projectImage->image);
             $projectImage->delete();
        }
        $project->delete();
        return redirect()->route('projects.index')->with('toast.success', 'Project deleted successfully');
    }
}
