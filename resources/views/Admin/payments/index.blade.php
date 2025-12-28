<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">All Payments</h1>
        </div>
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">Transaction Id</th>
                    <th class="py-2 px-4 border">Client</th>
                    <th class="py-2 px-4 border">Freelancer</th>
                    <th class="py-2 px-4 border">Project</th>
                    <th class="py-2 px-4 border">Amount</th>
                    <th class="py-2 px-4 border">Payment Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td class="py-2 px-4 border">{{ $payment->transaction_id }}</td>
                        <td class="py-2 px-4 border">{{ ucwords($payment->client->name) }}</td>
                        <td class="py-2 px-4 border">{{ ucwords($payment->freelancer->name) }}</td>
                        <td class="py-2 px-4 border">{{ ucwords($payment->postProject->project_name)}}</td>
                        <td class="py-2 px-4 border">${{ number_format($payment->amount, 2) }}</td>
                        <td class="py-2 px-4 border">{{\Carbon\Carbon::parse($payment->created_at)->format('d M, Y')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{$payments->links()}}
        </div>
    </div>
</x-app-layout>
