<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    // Method to show the list of job offers (optional)
    public function index()
    {
        $jobOffers = JobOffer::latest()->take(5)->get(); // Get the latest job offers
        return view('job-offers.index', compact('jobOffers'));
    }

    // Method to show a single job offer's details
    public function show($id)
    {
        $jobOffer = JobOffer::findOrFail($id); // Fetch the job offer by ID
        return view('job-offers.show', compact('jobOffer'));
    }
}

