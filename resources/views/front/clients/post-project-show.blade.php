@extends('layouts.secondary')
@section('content')
     <?php
     $totalAmountToPay = $postProject->budget;
     session(['total' => $totalAmountToPay]);
     ?>
     <div class="container mx-auto p-6">
         <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
             <h3 class="text-2xl font-semibold text-gray-800 mb-4">Make a Payment</h3>
             @if(session("failureMsg"))
                 <div class="bg-red-500 text-white p-3 rounded mb-4" id="paymentErrorAlert">
                     <span>{{ session("failureMsg") }}</span>
                 </div>
             @endif
             <div class="bg-red-500 text-white p-3 rounded mb-4 hidden" id="validationErrorAlert">
                 <span id="validationErrorText"></span>
             </div>

             <div class="bg-gray-100 p-4 rounded-lg mb-4">
                 <h4 class="text-lg font-medium text-gray-700">Project Details</h4>
                 <ul class="text-gray-600 mt-2">
                     <li class="mb-2"><strong>Title:</strong> {{ $postProject->project_name }}</li>
                     <li class="mb-2"><strong>Freelancer:</strong> {{ ucwords($postProject->freelancer->name) }}</li>
                     <li class="mb-2"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($postProject->deadline)->format('d M, Y') }}</li>
                     <li class="mb-2"><strong>Description:</strong> {{ $postProject->project_description }}</li>
                     <li class="mb-2"><strong>Budget:</strong> ${{ $totalAmountToPay }}</li>
                     <li class="mb-2"><strong>Status: </strong> <span
                        @class([
            'ml-2 px-3 py-1 text-sm font-semibold rounded-full',
            'bg-blue-500 text-white' => $postProject->status === \App\Enums\PostProjectStatus::ACCEPTED,
            'bg-green-500 text-white' => $postProject->status === \App\Enums\PostProjectStatus::COMPLETED,
            'bg-yellow-500 text-black' => $postProject->status === \App\Enums\PostProjectStatus::PENDING,
            'bg-red-500 text-white' => $postProject->status === \App\Enums\PostProjectStatus::REJECTED,
        ])>{{$postProject->status->label()}}</span></li>
                 </ul>
             </div>

             <div class="bg-gray-50 p-4 rounded-lg mb-4">
                 <h4 class="text-lg font-medium text-gray-700">Payment Summary</h4>
                 <div class="flex justify-between mt-2 text-gray-700">
                     <span>Subtotal</span>
                     <span>${{ $totalAmountToPay }}
                     @if($postProject->status === \App\Enums\PostProjectStatus::COMPLETED)
                         <span class="ml-2 px-3 py-1 text-sm font-semibold rounded-full bg-gray-400">Paid</span>
                     @endif
                     </span>
                 </div>
             </div>

             @if($postProject->status === \App\Enums\PostProjectStatus::ACCEPTED)
             <div class="bg-white p-4 shadow-md rounded-lg">
                 <div class="mt-4 flex items-center">
                     <input type="checkbox" id="terms_checkbox" class="mr-2 rounded border-gray-300 text-blue-500 focus:ring-blue-400">
                     <label for="terms_checkbox" class="text-gray-700 text-sm">I agree to {{config('app.name')}} <a href="#" class="text-blue-500 hover:underline">terms and conditions</a> and <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a>.</label>
                 </div>

                 <div class="mt-4" id="paypal-card-element"></div>

                 <form action="{{route('clients.payment.fulfillOrder', $postProject->id)}}" id="payment-form-paypal" method="POST" class="hidden">
                     @csrf
                     <input type="hidden" id="transaction_paypal" name="transaction_id">
                     <input type="hidden" id="total_paypal" name="total" value="{{ $totalAmountToPay }}">
                 </form>
             </div>
             @endif
         </div>
     </div>
@endsection
@if($postProject->status === \App\Enums\PostProjectStatus::ACCEPTED)
@push('scripts')
@include('_partials._paypal-scripts', ['total' => $totalAmountToPay])
@endpush
@endif