@extends('layouts.secondary')

@section('content')
<div class="relative min-h-screen py-16">
    <!-- Background Image with Overlay (Full Width) -->
    <div class="fixed inset-0 -z-10 w-90 h-full">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
             alt="Freelance workspace background"
             class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/70 to-purple-900/70"></div>
    </div>

    <!-- Main Content (Centered Container) -->
    <div class="container mx-auto relative z-10">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-xl animate-fade-in-down">Let’s Create Something Epic</h1>
            <p class="text-lg md:text-xl text-gray-100 max-w-2xl mx-auto">Your freelance partner in turning ideas into reality, wherever you are.</p>
        </div>

        <div class="flex flex-wrap -mx-4">
            <!-- Contact Form -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="bg-white/95 backdrop-blur-lg p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/30">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 text-indigo-900 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Reach Out</h2>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(session('success'))
                        <div class="alert alert-success bg-green-50 text-green-700 p-4 rounded-lg border border-green-200">{{ session('success') }}</div>
                        @endif
                        <div class="relative">
                            <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                            <input type="text" name="name" id="name"
                                   class="mt-2 block w-full border-0 bg-gray-100/50 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 transition-all duration-300"
                                   placeholder="John Doe">
                            <span class="absolute right-4 top-12 text-gray-500"><i class="fas fa-user"></i></span>
                        </div>
                        <div class="relative">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email"
                                   class="mt-2 block w-full border-0 bg-gray-100/50 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 transition-all duration-300"
                                   placeholder="john@example.com">
                            <span class="absolute right-4 top-12 text-gray-500"><i class="fas fa-envelope"></i></span>
                        </div>
                        <div class="relative">
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="message" id="message" rows="4"
                                      class="mt-2 block w-full border-0 bg-gray-100/50 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 transition-all duration-300"
                                      placeholder="What’s your next big idea?"></textarea>
                            <span class="absolute right-4 top-12 text-gray-500"><i class="fas fa-comment"></i></span>
                        </div>
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                            <span class="font-semibold">Send now</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="bg-white/95 backdrop-blur-lg p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/30">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 text-indigo-900 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Quick Answers</h2>
                    <div class="space-y-6">
                        <div class="transform hover:-translate-y-1 transition-all duration-300">
                            <h3 class="font-semibold text-xl text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-code mr-3 text-purple-600"></i> What I Offer
                            </h3>
                            <p class="text-gray-600">Bespoke websites, apps, and solutions crafted just for you.</p>
                        </div>
                        <div class="transform hover:-translate-y-1 transition-all duration-300">
                            <h3 class="font-semibold text-xl text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-clock mr-3 text-purple-600"></i> How fast can I deliver?
                            </h3>
                            <p class="text-gray-600">Projects delivered in 1-4 weeks, with expedited options.</p>
                        </div>
                        <div class="transform hover:-translate-y-1 transition-all duration-300">
                            <h3 class="font-semibold text-xl text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-handshake mr-3 text-purple-600"></i> Let’s Team Up
                            </h3>
                            <p class="text-gray-600">Reach out, and let’s brainstorm over a virtual chat!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Details Section (No Frame) -->
        <div class="mt-16 px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center text-white bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent drop-shadow-md">Get in Touch</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Email Card -->
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="flex justify-center mb-4">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-full text-white shadow-md">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Email Me</h3>
                    <p class="text-gray-600 mb-3">freelancer@example.com</p>
                    <a href="mailto:freelancer@example.com" class="text-sm text-purple-600 hover:text-purple-800 transition-colors font-medium">Drop a Line</a>
                </div>
                <!-- Phone Card -->
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="flex justify-center mb-4">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-full text-white shadow-md">
                            <i class="fas fa-phone text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Call Me</h3>
                    <p class="text-gray-600 mb-3">+977 123-456-7890</p>
                    <a href="tel:+9771234567890" class="text-sm text-purple-600 hover:text-purple-800 transition-colors font-medium">Ring Me Up</a>
                </div>
                <!-- Location Card -->
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="flex justify-center mb-4">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-full text-white shadow-md">
                            <i class="fas fa-map-marker-alt text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Based In</h3>
                    <p class="text-gray-600 mb-3">Kathmandu, Nepal</p>
                    <span class="text-sm text-gray-500 italic">Available Worldwide</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 1s ease-out;
    }
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<!-- No scripts needed -->
@endsection
