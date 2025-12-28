<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ClientProfileController extends Controller
{
    // Show the profile edit form
    public function edit()
    {
        $client = Auth::user();
        return view('clientDashboard.edit-profile', compact('client'));
    }

    // Handle the profile update request
    public function update(Request $request)
    {
        $request->validate([
             'name'          => 'required|string|max:255',
             'location'      => 'nullable|string|max:255',
             'profile_image' => 'nullable|image|max:2048',
        ]);

        $client = Auth::user();
        $client->name = $request->name;
        $client->location = $request->location;

        if ($request->hasFile('profile_image')) {
            if ($client->profile_image && Storage::disk('public')->exists($client->profile_image)) {
                Storage::disk('public')->delete($client->profile_image);
            }
            // Store the new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $client->profile_image = $imagePath;
        }
        // Save the changes
        $client->save();

        return redirect()->route('clients.profile.edit')->with('toast.success', 'Profile updated successfully!');
    }
}
