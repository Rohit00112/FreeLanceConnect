<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Rating;
use App\Models\User;
use function Pest\Laravel\get;

class ClientFreelancerProfileController extends Controller
{
    public function show($id)
    {
        $freelancer = User::query()->where('id', $id)
            ->where('role', UserRole::FREELANCER)
            ->with(['projects', 'freelanceProjects', 'reviews'])
            ->firstOrFail();

        $allReviews = Rating::query()->with('client')->where('freelancer_id', $id)->where('rating', '>=', 4)->get();
        return view('clientFreelancer.profile', compact('freelancer', 'allReviews'));
    }
}
