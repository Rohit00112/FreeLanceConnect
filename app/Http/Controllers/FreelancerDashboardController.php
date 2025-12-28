<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class FreelancerDashboardController extends Controller
{
    public function index()
    {
        $projects = Project::query()->where('user_id', Auth::id())->get();
        return view('freelancer-dashboard', compact('projects'));
    }
}

