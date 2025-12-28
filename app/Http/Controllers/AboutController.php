<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Define the team members data
        $teamMembers = [
            [
                'image' => 'path_to_image1.jpg',
                'name' => 'John Doe',
                'role' => 'Founder',
                'description' => 'John is the founder of Freelance Connect and leads the team.'
            ],
            [
                'image' => 'path_to_image2.jpg',
                'name' => 'Jane Smith',
                'role' => 'Developer',
                'description' => 'Jane is a talented developer who works on the platform’s backend.'
            ],
            // Add more team members as needed
        ];

        // Pass the data to the view
        return view('About.About', compact('teamMembers'));
    }
}
