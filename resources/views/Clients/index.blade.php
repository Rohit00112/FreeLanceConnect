<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        <main class="dashboard-content w-full p-6">
            <!-- Pending Projects Section -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                        <i class="fas fa-project-diagram mr-2"></i> Projects from Client
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Project Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Client</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Budget</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Deadline</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Description</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse ($pendingProjects as $project)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $project->project_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $project->client->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${{ number_format($project->budget, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $project->deadline->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $project->project_description }}</td>
                                        <td class="px-6 py-4 text-sm flex space-x-2">
                                            <form action="{{ route('freelancer.projects.accept', $project->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirmAccept()">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-500 hover:bg-green-600 rounded-lg flex items-center transition-colors duration-200">
                                                    <i class="fas fa-check mr-2"></i> Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('freelancer.projects.reject', $project->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirmReject()">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg flex items-center transition-colors duration-200">
                                                    <i class="fas fa-times mr-2"></i> Reject
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">No pending projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Accepted Projects Section -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i> Accepted Projects
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Project Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Client</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Budget</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Deadline</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Description</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse ($acceptedProjects as $project)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $project->project_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $project->client->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${{ number_format($project->budget, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $project->deadline->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $project->project_description }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <form action="{{ route('freelancer.projects.delete', $project->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg flex items-center transition-colors duration-200">
                                                    <i class="fas fa-trash mr-2"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">No accepted projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Debugging Output -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <button class="w-full text-left flex items-center justify-between text-lg font-bold text-gray-800 dark:text-gray-100 mb-4" onclick="toggleDebug()">
                    <span><i class="fas fa-bug mr-2"></i> Information</span>
                    <i class="fas fa-chevron-down transition-transform duration-200" id="debugChevron"></i>
                </button>
                <div id="debugContent" class="hidden">
                    <p class="text-gray-600 dark:text-gray-300">Total Pending Projects: <span class="font-semibold">{{ $pendingProjects->count() }}</span></p>
                    <p class="text-gray-600 dark:text-gray-300">Total Accepted Projects: <span class="font-semibold">{{ $acceptedProjects->count() }}</span></p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function confirmAccept() {
            return confirm("Are you sure you want to accept this project?");
        }

        function confirmReject() {
            return confirm("Are you sure you want to reject this project?");
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this project?");
        }

        function toggleDebug() {
            const debugContent = document.getElementById('debugContent');
            const chevron = document.getElementById('debugChevron');
            debugContent.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }
    </script>
</x-app-layout>
