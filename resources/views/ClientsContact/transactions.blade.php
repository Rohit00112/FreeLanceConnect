@extends('layouts.secondary')

@section('content')
<div class="container mx-auto py-16">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Transaction History</h1>

    <!-- Date Filter -->
    <div class="mb-6 flex justify-end">
        <div class="flex items-center space-x-4">
            <label for="date-filter" class="text-gray-700 font-medium">Filter by Date:</label>
            <input type="date" id="date-filter" class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="clear-filter" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Clear</button>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Project Name</th>
                    <th class="py-3 px-6 text-left">Recipient</th>
                    <th class="py-3 px-6 text-center">Actions</th>


                </tr>
            </thead>
            <tbody id="transaction-table-body">
                @foreach($transactions as $transaction)
                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition duration-200" data-date="{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}">
                    <td class="py-4 px-6 border-b border-gray-200">
                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d H:i:s') }}
                        <!-- Hidden span for debugging -->
                        <span class="debug-date" style="display: none;">{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</span>
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200">${{ number_format($transaction->amount, 2) }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $transaction->project_name }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $transaction->recipient_name }}</td>
                    <td class="py-4 px-6 border-b border-gray-200 text-center">
                        <button class="text-red-500 hover:text-red-700 transition duration-150" onclick="if(confirm('Are you sure you want to delete this transaction?')) { window.location.href='/transactions/delete/{{ $transaction->id }}'; }">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        text-align: left;
        font-size: 0.95rem;
    }
    th {
        font-weight: 600;
    }
    tr {
        transition: background-color 0.2s ease;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded, initializing date filter');

        const dateFilter = document.getElementById('date-filter');
        const clearFilter = document.getElementById('clear-filter');
        const tableBody = document.getElementById('transaction-table-body');

        // Check if elements exist
        if (!dateFilter) {
            console.error('Date filter element not found');
            return;
        }
        if (!clearFilter) {
            console.error('Clear filter button not found');
            return;
        }
        if (!tableBody) {
            console.error('Table body not found');
            return;
        }

        const rows = tableBody.getElementsByTagName('tr');
        console.log('Number of rows found:', rows.length);

        // Log initial data-date attributes for debugging
        for (let i = 0; i < rows.length; i++) {
            const rowDate = rows[i].getAttribute('data-date');
            const debugDate = rows[i].querySelector('.debug-date')?.innerText;
            console.log(`Row ${i} - data-date: ${rowDate}, debug-date: ${debugDate}`);
        }

        dateFilter.addEventListener('change', function() {
            const selectedDate = new Date(this.value).toISOString().split('T')[0];
            console.log('Selected Date:', selectedDate);

            if (!selectedDate) {
                console.log('No date selected, showing all rows');
                for (let i = 0; i < rows.length; i++) {
                    rows[i].style.display = '';
                }
                return;
            }

            let matchFound = false;
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const rowDate = row.getAttribute('data-date');

                if (!rowDate) {
                    console.warn(`Row ${i} has no data-date attribute`);
                    row.style.display = 'none';
                    continue;
                }



                console.log(`Comparing: Selected Date (${selectedDate}) with Row Date (${rowDate})`);
                if (rowDate === selectedDate) {
                    console.log(`Row ${i} matches - Showing`);
                    row.style.display = '';
                    matchFound = true;
                } else {
                    console.log(`Row ${i} does not match - Hiding`);
                    row.style.display = 'none';
                }
            }

            if (!matchFound) {
                console.log('No rows match the selected date');
            }
        });
        // Clear filter on button click
        dateFilter.value = '';
        clearFilter.value = '';
        dateFilter.dispatchEvent(new Event('change')); // Trigger initial filter to show all rows on page load.
        console.log('Initial filter triggered'); // Debugging: Showing all rows on page load.
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = '';
        } // Debugging: Showing all rows on page load. End.

        // Clear filter on button click
        clearFilter.addEventListener('click', function() {
            console.log('Clearing filter');
            dateFilter.value = '';
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = '';
            }
        });
    });
</script>
@endsection
