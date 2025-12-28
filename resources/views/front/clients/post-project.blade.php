@extends('layouts.secondary')
@section('title', 'Post Project')
@section('content')
    <div class="py-5 min-h-[calc(100vh-136px)] flex items-center justify-center mx-auto max-w-lg">
        <div class="mx-auto w-full bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Post a Project</h2>

            <form id="postProjectForm-{{ $freelancer->id }}" action="{{route('clients.post-project.store')}}" method="POST">
                @csrf
                <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">

                <!-- Project Title -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Project Title:</label>
                    <input type="text" name="title"
                           value="{{old('title')}}"
                           class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 @error('title') border-red-500 @enderror"
                           placeholder="Enter project title">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Description -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Project Description:</label>
                    <textarea name="description"
                              class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 @error('description') border-red-500 @enderror"
                              rows="4" placeholder="Describe your project" >{{old('description')}}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Budget ($):</label>
                    <input type="number" name="budget"
                           min="1"
                           value="{{old('budget')}}"
                           class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 @error('budget') border-red-500 @enderror"
                           placeholder="Enter budget">
                    @error('budget')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Deadline:</label>
                    <input type="date" name="deadline"
                           value="{{old('deadline')}}"
                           class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 @error('deadline') border-red-500 @enderror"
                           >
                    @error('deadline')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="reset"
                            class="px-4 py-2 rounded-lg bg-gray-400 text-white hover:bg-gray-500 transition">
                        Reset
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition">
                        Submit Proposal
                    </button>
                </div>
            </form>
        </div>


    </div>
@endsection
