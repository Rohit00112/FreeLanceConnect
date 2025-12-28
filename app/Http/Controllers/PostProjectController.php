<?php

namespace App\Http\Controllers;

use App\Enums\PostProjectStatus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PostProject;

class PostProjectController extends Controller
{
     public function index(Request $request)
     {
          $query = PostProject::query()
               ->with(['freelancer'])
               ->where('client_id', auth()->user()->id)
               ->when($request->filled('status'), function($query) use ($request) {
                    return $query->where('status', $request->status);
               });

          $allPostProjects = $query->paginate(9);

          return view('front.clients.projects', compact('allPostProjects'));
     }

     public function create(User $user)
     {
          if(!$user->isFreelancer()){
               abort(403);
          }
          return view('front.clients.post-project', ['freelancer' => $user]);
     }

     public function store(Request $request)
     {
          $request->validate([
               'freelancer_id' => 'required|exists:users,id',
               'title'         => 'required|string|max:255',
               'description'   => 'required|string',
               'budget'        => 'required|numeric|min:1',
               'deadline'      => 'required|date|after:today',
          ]);

          PostProject::query()->create([
               'freelancer_id'       => $request->freelancer_id,
               'client_id'           => auth()->user()->id,
               'status'              => PostProjectStatus::PENDING,
               'project_name'        => $request->title,
               'project_description' => $request->description,
               'budget'              => $request->budget,
               'deadline'            => $request->deadline,
          ]);

          return redirect()->route('clients.freelancer.profile', $request->freelancer_id)->with('toast.success', 'Project posted successfully!');

     }

     public function show($id)
     {
          $postProject = PostProject::query()->with('freelancer')->findOrFail($id);
          if($postProject->client_id !== auth()->user()->id){
               abort(403);
          }
          return view('front.clients.post-project-show', ['postProject' => $postProject]);
     }

}
