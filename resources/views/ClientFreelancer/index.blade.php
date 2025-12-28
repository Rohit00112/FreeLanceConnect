@php
    use Illuminate\Support\Str;

@endphp
@extends('layouts.secondary')
@section('content')
    <!-- Hero Section (remains static or can be made dynamic as needed) -->
    <section class="relative bg-white-600 text-white py-20">
        <img alt="A vibrant and dynamic background image representing creativity and collaboration"
            class="absolute inset-0 w-full h-full object-cover opacity-50" height="600"
            src="https://storage.googleapis.com/a1aa/image/IMxeXHEp5K0z6walK8pZDoZAT2ZOCllxkuE3inSMxU4.jpg" width="1920" />
        <div class="container text-center relative z-10">
            <h1 class="text-4xl text-purple-600 font-bold mb-4">Find the Best Freelancers for Your Projects</h1>
            <p class="text-lg text-purple-600 mb-8">Browse through our talented freelancers and find the right fit for your
                project needs.</p>
            <a href="#freelancer-grid" class="bg-purple-600 text-white-600 px-6 py-3 rounded-full font-semibold">Post a
                Project</a>
        </div>
    </section>
    <!-- Advanced Search Section (optional, can be connected to a search controller) -->
    <section class="py-10 bg-gray-100">
        <div class="container">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold">Find Freelancers</h2>
                <p class="text-gray-600">Search for the perfect freelancer for your job.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form method="GET" action="{{ route('clients.freelancers.index') }}"
                    class="grid grid-cols-1 lg:grid-cols-5 gap-4 items-center">

                    <input type="text" name="name" value="{{ request('name') }}"
                        placeholder="Freelancer Name" class="border border-gray-300 p-2 rounded">

                    <input type="text" name="skills" value="{{ request('skills') }}"
                        placeholder="Skills (e.g., PHP, React)" class="border border-gray-300 p-2 rounded">

                    <input type="text" name="experience" value="{{ request('experience') }}"
                        placeholder="Experience" class="border border-gray-300 p-2 rounded">

                    <input type="text" name="budget" value="{{ request('budget') }}"
                        placeholder="Budget" class="border border-gray-300 p-2 rounded">

                    <input type="text" name="location" value="{{ request('location') }}"
                        placeholder="Location (e.g., New York)" class="border border-gray-300 p-2 rounded">

                    <div class="lg:col-span-5 flex justify-center">
                        <button type="submit"
                            class="bg-purple-600 text-white px-6 py-2 rounded w-full lg:w-auto">Search</button>
                    </div>
                </form>
            </div>

        </div>
    </section>


<!-- Recommended Freelancers Section -->
<section class="py-9 bg-gradient-to-r from-purple-100 to-purple-50">
    <div class="container">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-purple-700">⭐ Recommended Freelancers</h2>
            <p class="text-lg text-gray-700">Based on ratings and expertise</p>
        </div>

        <!-- Scrollable Container -->
        <div class="relative">
            <button id="scroll-left" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-purple-600 text-white px-3 py-2 rounded-full shadow-md">
                ❮
            </button>

            <div id="carousel-container" class="flex gap-6 overflow-x-auto whitespace-nowrap scroll-smooth p-1">
                @foreach ($recommendedFreelancers as $freelancer)
                    <div class="min-w-[300px] bg-white p-6 rounded-lg shadow-lg border-2 border-yellow-400 hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Top Rated</span>

                        <img alt="{{ $freelancer->name }}'s Profile Picture"
                             class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-yellow-400 shadow-md"
                             src="{{ $freelancer->profile_image ? asset('storage/' . $freelancer->profile_image) : asset('images/default-avatar.png') }}"
                             width="128" height="128" />

                        <h3 class="text-2xl font-semibold text-center text-purple-800">{{ $freelancer->name }}</h3>
                        <p class="text-gray-600 text-center mb-4">Freelancer</p>

                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            @foreach (explode(',', $freelancer->skills) as $skill)
                                <span class="bg-purple-200 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>

                        <a href="{{ route('clients.freelancer.profile', ['id' => $freelancer->id]) }}"
                           class="block bg-purple-600 text-white font-semibold text-center py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                            View Profile
                        </a>
                    </div>
                @endforeach
            </div>

            <button id="scroll-right" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-purple-600 text-white px-3 py-2 rounded-full shadow-md">
                ❯
            </button>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("carousel-container");
        const scrollLeft = document.getElementById("scroll-left");
        const scrollRight = document.getElementById("scroll-right");

        scrollLeft.addEventListener("click", function() {
            container.scrollBy({ left: -300, behavior: "smooth" });
        });

        scrollRight.addEventListener("click", function() {
            container.scrollBy({ left: 300, behavior: "smooth" });
        });
    });
</script>



    <!-- Freelancers Listings Section (Dynamic) -->
    <section class="py-20">
        <div class="container">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Our Freelancers</h2>
                <p class="text-gray-600">Browse through the profiles of our top freelancers.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="freelancer-grid">
                @foreach ($freelancers as $freelancer)
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <!-- Freelancer Image (if profile_image is set; otherwise use a default image) -->
                        <img alt="{{ $freelancer->name }}'s Profile Picture" class="w-24 h-24 rounded-full mx-auto mb-4"
                            src="{{ $freelancer->profile_image ? asset('storage/' . $freelancer->profile_image) : asset('images/default-avatar.png') }}"
                            width="96" height="96" />
                        <h3 class="text-xl font-semibold mb-2 text-center">{{ $freelancer->name }}</h3>
                        <p class="text-gray-600 mb-4 text-center">Freelancer</p>
                        <!-- Display Skills (assumes skills stored as comma-separated values) -->
                        <div class="flex justify-center space-x-2 mb-4">
                            @foreach (explode(',', $freelancer->skills) as $skill)
                                <span
                                    class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                            @endforeach
                        </div>

                        <div class="flex justify-center items-center mb-2">
                            @php
                                $averageRating = round($freelancer->reviews_avg_rating, 2);
                                $totalRatings = $freelancer->reviews_count;
                                $fullStars = floor($averageRating);
                                $halfStar = $averageRating - $fullStars >= 0.5;
                                $emptyStars = 5 - ceil($averageRating);
                            @endphp
                            <!-- Full Stars -->
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-yellow-500"></i>
                            @endfor
                            <!-- Half Star -->
                            @if ($halfStar)
                                <i class="fas fa-star-half-alt text-yellow-500"></i>
                            @endif
                            <!-- Empty Stars -->
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="fas fa-star text-gray-300"></i>
                            @endfor
                            <!-- Rating display -->
                        </div>
                        <span class="flex justify-center text-gray-500 text-xs">({{ number_format($averageRating, 1) }}
                            from {{ $totalRatings }} ratings)</span>
                        <a href="{{ route('clients.freelancer.profile', ['id' => $freelancer->id]) }}"
                            class="text-purple-600 font-semibold block text-center mt-4">
                            View Profile
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- Optional: Pagination links -->
            <div class="mt-8">
                {{ $freelancers->links('pagination::simple-tailwind') }}
            </div>
        </div>
    </section>

    <!-- Call to Action Section (static or dynamic as needed) -->
    <section class="py-20 bg-purple-600 text-white">
        <div class="container text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg mb-8">Post your project today and find the perfect freelancer to bring your ideas to life.
            </p>
            <a href="#freelancer-grid" class="bg-white text-purple-600 px-6 py-3 rounded-full font-semibold">Post a
                Project</a>
        </div>
    </section>
@endsection
