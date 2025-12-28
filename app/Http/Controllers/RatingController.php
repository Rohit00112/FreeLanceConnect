<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User; // User model where role is defined
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function reviewFreelancer(Request $request, User $freelancer)
    {
        $request->validate([
            'review' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
        ]);
         Rating::query()->updateOrCreate([
              'user_id'       => auth()->user()->id,
              'freelancer_id' => $freelancer->id
         ],[
              'review' => $request->review,
              'rating' => $request->rating,
         ]);

        return redirect()->back()->with('toast.success', 'Your review has been submitted.');
    }
}
