<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;

class ClientFreelancerController extends Controller
{
    public function index(Request $request)
    {
        // Start with all freelancers
        $query = User::query()
            ->withAvg('reviews', 'rating')
            ->withCount(['reviews'])
            ->where('role', UserRole::FREELANCER);

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if ($request->filled('skills')) {
            $query->where('skills', 'LIKE', '%' . $request->skills . '%');
        }

        if ($request->filled('budget')) {
            $query->where('project_budget', 'LIKE', '%' . $request->budget . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->filled('experience')) {
            $query->where('experience', 'LIKE', '%' . $request->experience . '%');
        }

        $freelancers = $query->paginate(9);

        // Recommendation logic
        $recommendedFreelancers = $this->getRecommendedFreelancers($request);

        return view('clientFreelancer.index', compact('freelancers', 'recommendedFreelancers'));
    }

    /**
     * Get recommended freelancers based on specific criteria.
     */
    private function getRecommendedFreelancers(Request $request)
    {
        // Example recommendation criteria: Top-rated freelancers
        return User::query()
            ->withAvg('reviews', 'rating')
            ->withCount(['reviews'])
            ->where('role', UserRole::FREELANCER)
            ->orderByDesc('reviews_avg_rating') // Highest ratings first
            ->limit(5) // Limit to top 3 freelancers
            ->get();
    }
}
