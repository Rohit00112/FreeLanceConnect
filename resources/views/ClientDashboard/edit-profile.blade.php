@extends('layouts.secondary')
@section('content')
    <div class="py-5 min-h-[calc(100vh-136px)] flex items-center justify-center mx-auto max-w-lg">
        <div class="mx-auto w-full bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-3xl font-semibold text-center text-purple-600 mb-6">Edit Profile</h2>
            <form action="{{ route('clients.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" name="name" type="text" :value="old('name', $client->name)" required
                                  autofocus autocomplete="name"/>
                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                </div>

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" :value="$client->email" disabled class="cursor-not-allowed"/>
                </div>

                <div class="mb-4">
                    <x-input-label for="location" :value="__('Location')"/>
                    <x-text-input id="location" name="location" type="text" :value="old('location', $client->location)"
                                  autofocus autocomplete="location"/>
                    <x-input-error class="mt-2" :messages="$errors->get('location')"/>
                </div>


                <!-- Profile Image Field -->
                <div class="mb-4">
                    <label for="profile_image" class="block text-gray-700 font-medium">Profile Image</label>
                    <!-- Display current image if exists -->
                    @if ($client->profile_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $client->profile_image) }}" alt="Profile Image"
                                 class="w-24 h-24 rounded-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="profile_image"
                           class="form-input mt-1 block w-full border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 rounded-md">
                </div>

                <div class="flex justify-center space-x-4">
                    <!-- Submit Button -->
                    <button type="submit"
                            class="bg-purple-600 text-white py-2 px-6 rounded-lg hover:bg-purple-700 transition duration-300">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
