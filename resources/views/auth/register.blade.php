<x-guest-layout>
    <div class="min-h-screen min-w-[500px] flex items-center justify-center text-white">
        <div class="bg-black w-full bg-opacity-70 rounded-lg shadow-lg p-8">
            <!-- Choose Account Type Header -->
            <h2 class="text-center text-xl font-semibold mb-6">
                Choose Account Type
            </h2>
            <!-- Account Type Options -->
            <div class="flex justify-center mb-6 space-x-8">
                <!-- Freelancer Option -->
                <label class="flex flex-col items-center cursor-pointer">
                    <input type="radio" name="account_type" value="freelancer" class="hidden peer" checked
                        onclick="document.getElementById('role').value='freelancer'" />
                    <img alt="Freelancer illustration"
                        class="mb-2 border-2 border-gray-300 rounded-full p-1 transition-colors duration-200 peer-checked:border-blue-500"
                        height="100" width="100"
                        src="https://storage.googleapis.com/a1aa/image/eJSdx50MVn8GOpZrfxsnerPk6eRx0-xT1VfMFEvxQ2w.jpg" />
                    <span class="text-sm font-medium transition-colors duration-200 peer-checked:text-blue-400">
                        Freelancer
                    </span>
                </label>
                <!-- Client Option -->
                <label class="flex flex-col items-center cursor-pointer">
                    <input type="radio" name="account_type" value="client" class="hidden peer"
                        onclick="document.getElementById('role').value='client'" />
                    <img alt="Client illustration"
                        class="mb-2 border-2 border-gray-300 rounded-full p-1 transition-colors duration-200 peer-checked:border-blue-500"
                        height="100" width="100"
                        src="https://storage.googleapis.com/a1aa/image/tLywGWOqfwi-L289uhrAYSkj5kQvYRjFI461Q7gQiE0.jpg" />
                    <span class="text-sm font-medium transition-colors duration-200 peer-checked:text-blue-400">
                        Client
                    </span>
                </label>
            </div>

            <!-- Optional: Check Icon -->
            <div class="flex justify-center mb-6">
                <i class="fas fa-check-circle text-blue-400 text-2xl"></i>
            </div>

            <!-- Welcome Message -->
            <p class="text-center text-gray-300 mb-6">
                Hello!!<br />
                Please fill out the form below to get started
            </p>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Full Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Full Name')" class="text-white" />
                    <x-text-input id="name" name="name" type="text"
                        class="block mt-1 w-full border border-gray-500 rounded-md p-2 bg-gray-800 text-white"
                        :value="old('name')" autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email Address')" class="text-white" />
                    <div class="relative">
                        <x-text-input id="email" name="email" type="text" {{-- Changed from email to text --}}
                            class="block mt-1 w-full border border-gray-500 rounded-md p-2 bg-gray-800 text-white"
                            :value="old('email')" />
                        <i class="fas fa-envelope absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>


                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <div class="relative">
                        <x-text-input id="password" name="password" type="password"
                            class="block mt-1 w-full border border-gray-500 rounded-md p-2 bg-gray-800 text-white"
                            autocomplete="new-password" />
                        <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                        class="block mt-1 w-full border border-gray-500 rounded-md p-2 bg-gray-800 text-white"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                </div>

                <!-- Hidden Role Field -->
                <input type="hidden" name="role" id="role" value="freelancer" />

                <!-- Already have an account? -->
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-300">
                        Already have an account?
                        <a class="text-blue-400 hover:underline" href="{{ route('login') }}">
                            {{ __('Log in') }}
                        </a>
                    </p>
                </div>

                <!-- Register Button -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Register') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
