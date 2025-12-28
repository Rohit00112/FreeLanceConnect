<x-app-layout>
    <div class="py-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <h1 class="text-2xl font-bold mb-5 text-center">Admin Dashboard</h1>

                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Clients Overview -->
                    <div class="bg-blue-500 text-white p-5 rounded-lg shadow-md text-center">
                        <h2 class="text-lg font-semibold">Total Clients</h2>
                        <p class="text-3xl font-bold">{{ $clients }}</p>
                    </div>

                    <!-- Freelancers Overview -->
                    <div class="bg-green-500 text-white p-5 rounded-lg shadow-md text-center">
                        <h2 class="text-lg font-semibold">Total Freelancers</h2>
                        <p class="text-3xl font-bold">{{ $freelancers }}</p>
                    </div>

                    <!-- Payments Overview -->
                    <div class="bg-yellow-500 text-white p-5 rounded-lg shadow-md text-center">
                        <h2 class="text-lg font-semibold">Total Payments</h2>
                        <p class="text-3xl font-bold">${{ number_format($payments, 2) }}</p>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bar Chart for Users -->
                    <div class="bg-white p-12 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold mb-3 text-center">Users Overview</h2>
                        <canvas id="usersChart"></canvas>
                    </div>

                    <!-- Pie Chart for Payments -->
                    <div class="bg-white p-12 rounded-lg shadow-md w-80 mx-auto">
                        <h2 class="text-md font-semibold mb-2 text-center">Payments Breakdown</h2>
                        <div class="flex justify-center">
                            <canvas id="paymentsChart" width="200" height="250"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Users Bar Chart
        const usersChart = new Chart(document.getElementById('usersChart'), {
            type: 'bar',
            data: {
                labels: ['Clients', 'Freelancers'],
                datasets: [{
                    label: 'Users Count',
                    data: [{{ $clients }}, {{ $freelancers }}],
                    backgroundColor: ['#3b82f6', '#10b981'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Payments Pie Chart
        const paymentsChart = new Chart(document.getElementById('paymentsChart'), {
            type: 'pie',
            data: {
                labels: ['Completed Payments', 'Pending Payments'],
                datasets: [{
                    data: [{{ $payments }}, {{ $pendingPayments ?? 0 }}],
                    backgroundColor: ['#fbbf24', '#f87171']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</x-app-layout>
