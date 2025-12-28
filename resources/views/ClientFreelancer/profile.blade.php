@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.secondary')
@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded p-6">
            <div class="mb-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ ucwords($freelancer->name) }}</h1>
                <a href="{{route('clients.post-project.create', $freelancer)}}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-900">Post Proposal</a>
            </div>
            <p class="mb-3"><strong>Email:</strong> {{ $freelancer->email }}</p>
            <p class="mb-3"><strong>Skills:</strong>
                @foreach (explode(',', $freelancer->skills) as $skill)
                    <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                @endforeach
            </p>
            <p class="mb-3"><strong>Experience:</strong> {{ $freelancer->experience }} </p>
            <p class="mb-3"><strong>Budget:</strong> {{ $freelancer->project_budget }} </p>
            <p class="mb-4"><strong>Location:</strong> {{ $freelancer->location }} </p>
            <!-- Freelancer Projects Section -->
                <h2 class="text-xl font-bold mb-3">Projects by {{ ucwords($freelancer->name) }}</h2>
                @if ($freelancer->projects->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($freelancer->projects as $project)
                            <div class="bg-gray-100 p-4 rounded shadow">
                                <h3 class="text-lg font-semibold">{{ $project->name }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($project->description, 100) }}</p>


                                @if ($project->images->count() > 0)
                                    <img src="{{ asset('storage/' . $project->images->first()->image) }}"
                                         alt="Project Image" class="w-full h-40 object-cover mt-2 rounded">
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No projects available.</p>
                @endif
            @if(auth()->user()->id !== $freelancer->id)
                <!-- Start Chat Button -->
                <a href="{{ route('chat.index', ['otherUserId' => $freelancer->id]) }}"
                   class="inline-block bg-purple-600 text-white px-4 py-2 mt-4 rounded hover:bg-blue-700">
                    Start Chat
                </a>
            @endif
        </div>
        <div class="bg-white shadow rounded p-6 mt-6">
            <h2 class="text-xl font-bold mb-4">Review to {{ $freelancer->name }}</h2>
            <form action="{{ route('clients.review.freelancer', $freelancer->id) }}" method="POST">
                @csrf
                 <?php
                 $myCurrentReview = $freelancer->reviews->firstWhere(function($element)
                 {
                      return $element->user_id === auth()->user()->id;
                 });
                 $reviewText = old('review', $myCurrentReview?->review)
                 ?>
                <div class="mb-4" x-data="
	{
		rating: {{$myCurrentReview?->rating ?? 1}},
		hoverRating:  {{$myCurrentReview?->rating ?? 1}},
		ratings: [{'amount': 1}, {'amount': 2}, {'amount': 3}, {'amount': 4,}, {'amount': 5}],
	}">
                    <div class="flex space-x-0">
                        <template x-for="(star, index) in ratings" :key="index">
                            <button
                                    type="button"
                                    @click="rating = star.amount" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating"
                                    aria-hidden="true"
                                    :title="star.label"
                                    class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline w-10 m-0 cursor-pointer"
                                    :class="{'text-gray-600': hoverRating >= star.amount, 'text-yellow-400': rating >= star.amount && hoverRating >= star.amount}">
                                <svg class="w-15 transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>

                        </template>
                    </div>
                <input type="hidden" name="rating" x-model="rating">
                </div>
                <div class="mb-2">
                     <textarea name="review" rows="4" class="w-full border rounded p-2"
                               required>{{$reviewText}}</textarea>

                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Submit Review
                </button>
            </form>
        </div>
        <div class="bg-white pb-24 pt-5">
            <div class="px-6 lg:px-8">
                <div class="text-center">
                    <p class="mt-2 text-balance text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Review From Previous Clients</p>
                </div>
                <div class="mt-10 flow-root lg:mx-0 lg:max-w-none">
                    <div class="-mt-8 sm:-mx-4 sm:columns-2 sm:text-[0] lg:columns-3">
                        @foreach($allReviews as $reviewObj)
                            <div class="pt-8 sm:inline-block sm:w-full sm:px-4">
                                <figure class="rounded-2xl bg-gray-50 p-8 text-sm/6">
                                    <blockquote class="text-gray-900">
                                        <p>{{$reviewObj->review}}</p>
                                    </blockquote>
                                    <figcaption class="mt-6 flex items-center gap-x-4">
                                        <?php
                                          $profileImg = $reviewObj->client->profile_image ? asset('storage/' . $reviewObj->client->profile_image) :  asset('images/default-avatar.png')
                                          ?>
                                        <img class="size-10 rounded-full bg-gray-50" src="{{$profileImg}}" alt="">
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ucwords($reviewObj->client->name)}}</div>
                                            <div class="text-gray-600">{{$reviewObj->client->email}}</div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
