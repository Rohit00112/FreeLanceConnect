<x-app-layout>
    <div class="flex">
        <!-- Main Content -->
        <div class="flex-grow p-6 overflow-y-auto">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
                {{ __('Edit Profile') }}
            </h2>
            <div class="space-y-6">
                <!-- Profile Image Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
                    <h3 class="text-2xl font-semibold" style="color: #7F55E0; margin-bottom: 24px;">Profile Image</h3>
                    <div class="max-w-xl mx-auto text-center">
                        @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image"
                            class="w-32 h-32 rounded-full mx-auto mb-4">
                        @endif
                        <form action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" name="profile_image">
                            <button type="submit"
                                class="mt-4 px-4 py-2 bg-purple-600 text-white rounded hover:bg-blue-700">Update
                                Image</button>
                        </form>

                    </div>
                </div>

                <!-- Update Profile Information Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
                    <h3 class="text-2xl font-semibold" style="color: #7F55E0; margin-bottom: 24px;">Update Profile Information</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
                    <h3 class="text-2xl font-semibold" style="color: #7F55E0; margin-bottom: 24px;">Update Password</h3>
                    @include('profile.partials.update-password-form')
                </div>
@if(auth()->user()->isFreelancer())
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
                    <h3 class="text-2xl font-semibold" style="color: #7F55E0; margin-bottom: 24px;">Additional Information</h3>
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Additional Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update yours additional information") }}
                            </p>
                        </header>
                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label for="skills" :value="__('Skills')" />
                                <small class="text-xs text-gray-500">Comma Separated Skills</small>
                                <x-text-input id="skills" name="skills" type="text"  :value="old('skills', $user->skills)" required autofocus autocomplete="skills" />
                                <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                            </div>

                            <div>
                                <x-input-label for="experience" :value="__('Experience')" />
                                <x-text-input id="experience" name="experience" type="text" :value="old('experience', $user->experience)" required autocomplete="experience" />
                                <x-input-error class="mt-2" :messages="$errors->get('experience')" />
                            </div>

                            <div>
                                <x-input-label for="project_budget" :value="__('Project Budget')" />
                                <x-text-input id="project_budget" name="project_budget" type="text" :value="old('project_budget', $user->project_budget)" required autocomplete="project_budget" />
                                <x-input-error class="mt-2" :messages="$errors->get('project_budget')" />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" name="location" type="text" :value="old('location', $user->location)" required autocomplete="location" />
                                <x-input-error class="mt-2" :messages="$errors->get('location')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
@endif
            </div>
        </div>
    </div>
</x-app-layout>
