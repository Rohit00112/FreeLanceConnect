<x-guest-layout>
    <div class="min-h-screen min-w-[400px] flex items-center justify-center">
        <div class="bg-black w-full bg-opacity-70 rounded-lg shadow-lg p-8">


        <h2 class="text-2xl font-semibold text-center text-400 text-white">
            Forgot Password?
        </h2>
        <p class="text-sm text-gray-300 text-center mt-2">
            No problem! Enter your email, and we'll send you a password reset link.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="mt-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input
                    id="email"
                    class="block w-full px-4 py-2 mt-1 border border-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-800 text-white"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300 justify-center">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-400 hover:underline text-sm">
                Back to Login
            </a>
        </div>
    </div>
    </div>
</x-guest-layout>
