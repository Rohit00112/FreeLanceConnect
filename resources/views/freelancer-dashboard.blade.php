<x-app-layout>
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-grow bg-gray-100 dark:bg-gray-900">
            <div class="p-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Welcome, {{ auth()->user()->name }}!</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Manage your profile, explore job offers, and track your active projects.</p>

                        <!-- Cards Section -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Card 1: Active Projects -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Active Projects</h4>
                                <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-400">3</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Currently in progress</p>
                            </div>
                            <!-- Card 2: Pending Proposals -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Pending Proposals</h4>
                                <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-400">5</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Awaiting client response</p>
                            </div>
                            <!-- Card 3: Tasks Due -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Tasks Due</h4>
                                <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-400">2</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Due this week</p>
                            </div>
                        </div>

                        <!-- Chart Section -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Task Progress</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <canvas id="taskProgressChart" class="w-full h-20"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js for the Task Progress Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('taskProgressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Completed', 'In Progress', 'Not Started'],
                    datasets: [{
                        label: 'Tasks',
                        data: [10, 5, 3],
                        backgroundColor: [
                            'rgba(139, 92, 246, 0.6)', // Purple for Completed
                            'rgba(139, 92, 246, 0.4)', // Lighter Purple for In Progress
                            'rgba(139, 92, 246, 0.2)'  // Lightest Purple for Not Started
                        ],
                        borderColor: 'rgba(139, 92, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Tasks',
                                color: '#4B5563'
                            },
                            ticks: {
                                color: '#4B5563'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#4B5563'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#4B5563'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
