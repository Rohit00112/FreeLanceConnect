<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // Display the list of users (clients/freelancers)
    public function index()
    {
        // Fetch users from the database
        $users = User::query()->orderBy('id', 'desc')->paginate(15); // or any other logic you need

        return view('admin.users.index', compact('users'));
    }

     public function create()
     {
          return view('admin.users.create');
     }

     public function store(Request $request)
     {
          $request->validate([
               'name'     => ['required', 'string', 'max:255'],
               'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
               'password' => ['required', 'confirmed', Password::defaults()],
               'role'     => ['required', 'in:freelancer,client']
          ]);
          User::query()->create([
               'name'     => $request->name,
               'email'    => $request->email,
               'password' => Hash::make($request->password),
               'role'     => $request->role,
          ]);
          return redirect()->route('admin.users.index')->with('success', 'User created successfully.');

     }

    public function edit(User $user)
    {
         if($user->isAdmin()){
              return redirect()->back()->with('toast.error', 'Unauthorized');
         }
        return view('admin.users.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, User $user)
    {
         if($user->isAdmin()){
              return redirect()->back()->with('toast.error', 'Unauthorized');
         }
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'profile_image' => ['nullable', 'image', 'max:2048']
        ]);
         $imagePath = $user->profile_image;
         if ($request->hasFile('profile_image')) {
              $imagePath = $request->file('profile_image')->store('profile_images', 'public');

              if (!empty($user->profile_image) && Storage::disk('public')->exists($user->profile_image)) {
                   Storage::disk('public')->delete($user->profile_image);
              }
         }
        $user->update([
             'name'          => $request->name,
             'password'      => $request->password ? Hash::make($request->password) : $user->password,
             'profile_image' => $imagePath,
        ]);
        return redirect()->route('admin.users.index')->with('toast.success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
         if( $user->isAdmin() || auth()->user()->id = $user->id )
         {
              return redirect()->back()->with('toast.error', 'Unauthorized');
         }

         if( !empty($user->profile_image) && Storage::disk('public')->exists($user->profile_image) )
         {
              Storage::disk('public')->delete($user->profile_image);
         }
         $user->delete();
         return redirect()->route('admin.users.index')->with('toast.success', 'User deleted successfully');
    }
}

