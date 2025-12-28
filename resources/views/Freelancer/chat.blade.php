{{-- freelancer/chat.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl h-[800px]">
        <div class="bg-white shadow-lg rounded-lg">
            <div class="bg-purple-600 text-white text-center py-3 rounded-t-lg">
                <h4 class="text-lg font-semibold">Chat with Client #{{ $clientId }}</h4>
            </div>

            {{-- Messages Container --}}
            <div class="p-4 h-96 overflow-y-auto bg-gray-100" id="chat-box">
                @foreach ($messages as $message)
                    <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }} my-2">
                        <div class="relative group">
                            <div class="max-w-xs px-4 py-2 text-sm {{ $message->sender_id == Auth::id() ? 'bg-purple-500 text-white rounded-l-lg rounded-br-lg' : 'bg-gray-300 text-black rounded-r-lg rounded-bl-lg' }}">
                                <p class="font-semibold">{{ $message->sender_id == Auth::id() ? 'You' : 'Client' }}</p>
                                <p class="pr-12">{{ $message->message }}</p>

                                @if ($message->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $message->image) }}" alt="Image"
                                            class="max-w-xs rounded-lg">
                                    </div>
                                @endif

                                <small class="block text-xs {{ $message->sender_id == Auth::id() ? 'text-gray-200' : 'text-gray-700' }}">
                                    {{ $message->created_at }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
