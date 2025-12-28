<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
             'skills'         => ['nullable', 'string', 'max:255'],
             'experience'     => ['nullable', 'string', 'max:1000'],
             'project_budget' => ['nullable', 'string', 'max:255'],
             'location'       => ['nullable', 'string', 'max:255'],
             'name'           => ['nullable', 'string', 'max:255'],
        ]);
        $user->update($validated);
        return Redirect::route('profile.edit')->with('toast.success', 'Profile updated successfully.');
    }



    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_image' => ['nullable', 'image', 'max:2048']
        ]);

        $user = $request->user();

        if ($request->hasFile('profile_image')) {
           $imagePath = $request->file('profile_image')->store('profile_images', 'public');

           if (!empty($user->profile_image) && Storage::disk('public')->exists($user->profile_image)) {
               Storage::disk('public')->delete($user->profile_image);
           }

           $user->update(['profile_image' => $imagePath]);
        }

       return Redirect::route('profile.edit')->with('toast.success', 'Profile Image Updated');
    }


    /**
     * Delete the user's account.
     */
    /**
     * Delete the user's profile image if it exists.
     */
    private function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile image if exists
        $this->deleteOldImage($user->profile_image);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
