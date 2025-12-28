<x-app-layout>
    <div class="flex h-screen">
        <!-- Main Content Area -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="flex itmes-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Your Projects</h3>
                <a href="{{ route('projects.create') }}" class="bg-[#7F55E0] hover:bg-[#6A45C4] text-white font-bold py-2 px-4 rounded">
                    Add New Project
                </a>

            </div>

            <div class="mt-4 space-y-4">
                @forelse($projects as $project)
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md flex justify-between items-center">
                        <div>
                            <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $project->name }}</h5>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('projects.edit', $project->id) }}" class="bg-green-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-400">No projects found.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
