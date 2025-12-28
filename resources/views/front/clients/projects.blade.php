@extends('layouts.secondary')
@section('content')
<div class="container mx-auto my-5">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">All Projects</h1>
    <div class="mb-6 flex justify-end">
        <select id="projectStatusFilter" class="border border-gray-300 rounded px-4 py-2">
            <option value="">Select Status</option>
            @foreach(\App\Enums\PostProjectStatus::cases() as $status)
                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Project 1 -->
        @forelse($allPostProjects as $postProject)
            <div class="bg-white shadow-lg rounded-lg p-6 border border-transparent hover:border-purple-600 transition-all duration-300">
                <div class="flex flex-col h-full justify-between">
                    <div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-laptop-code text-purple-600 text-3xl mr-3"></i>
                            <h5 class="text-xl font-semibold text-purple-600">{{ucwords($postProject->project_name)}}</h5>
                        </div>
                        <p class="text-lg mb-2"><strong>Description:</strong> {{\Illuminate\Support\Str::limit($postProject->project_description)}}</p>
                        <p class="text-lg mb-2"><strong>Freelancer:</strong> <a class="text-purple-500" href="{{route('clients.freelancer.profile', $postProject->freelancer->id)}}">{{ucwords($postProject->freelancer->name)}}</a></p>
                        <p class="text-lg mb-2"><strong>Budget:</strong> ${{number_format($postProject->budget, 2)}}</p>
                        <p class="text-lg mb-2"><strong>Deadline:</strong> {{\Carbon\Carbon::parse($postProject->deadline)->format('d M, Y')}}</p>
                        <p class="text-lg mb-4"><strong>Status:</strong><span
                        @class([
            'ml-2 px-3 py-1 text-sm font-semibold rounded-full',
            'bg-blue-500 text-white' => $postProject->status === \App\Enums\PostProjectStatus::ACCEPTED,
            'bg-green-500 text-white' => $postProject->status === \App\Enums\PostProjectStatus::COMPLETED,
            'bg-yellow-500 text-black' => $postProject->status === \App\Enums\PostProjectStatus::PENDING,
            'bg-red-500 text-white' => $postProject->status === \App\Enums\PostProjectStatus::REJECTED,
        ])>{{$postProject->status->label()}}</span></p>
                    </div>
                    <a href="{{route('clients.post-projects.show', $postProject->id)}}" class="w-full bg-purple-600 text-center text-white py-3 rounded-lg hover:bg-purple-700 transition-all duration-300">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center bg-red-300 py-2 rounded md:col-span-3">
                <span class="text-red-600 font-bold">No Projects Found.</span>
            </div>
        @endforelse
    
    </div>
    <div class="mt-4">
    {{$allPostProjects->appends(request()->query())->links('pagination::simple-tailwind')}}
    </div>
</div>
@endsection
@push('scripts')
    <script>
        document.getElementById('projectStatusFilter').addEventListener('change', function() {
            let status = this.value;
            let url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        });
    </script>
@endpush
