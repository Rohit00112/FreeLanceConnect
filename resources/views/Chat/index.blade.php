{{-- chat/index.blade.php --}}
@extends('layouts.secondary')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="py-5 min-h-[calc(100vh-136px)] flex items-center justify-center mx-auto max-w-2xl">
        <div class="bg-white shadow-lg rounded-lg w-full">
            <div class="bg-purple-600 text-white text-center py-3 rounded-t-lg">
                <h4 class="text-lg font-semibold">Chat with {{ ucwords($otherUser->name) }}</h4>
            </div>

            {{-- Messages Container --}}
            <div class="p-4 h-96 overflow-y-auto bg-gray-100" id="chat-box">
                @foreach ($messages as $message)
                    <div id="message-{{ $message->id }}"
                         class="flex {{ $message->sender_id == auth()->user()->id ? 'justify-end' : 'justify-start' }} my-2">
                        <div class="relative group">
                            @if ($message->sender_id == auth()->user()->id)
                                <div
                                        class="absolute right-2 top-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                    <button onclick="deleteMessage('{{ $message->id }}')"
                                            class="text-gray-200 hover:text-red-800 p-1">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            @endif

                            <div
                                    class="max-w-xs px-4 py-2 text-sm {{ $message->sender_id == auth()->user()->id ? 'bg-purple-500 text-white rounded-l-lg rounded-br-lg' : 'bg-gray-300 text-black rounded-r-lg rounded-bl-lg' }}">
                                <p class="font-semibold">{{ $message->sender_id == auth()->user()->id ? 'You' : 'Them' }}</p>
                                <p id="message-content-{{ $message->id }}" class="pr-12">{{ $message->message }}</p>

                                @if ($message->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $message->image) }}" alt="Image"
                                             class="max-w-xs rounded-lg">
                                    </div>
                                @endif

                                <small
                                        class="block text-xs {{ $message->sender_id == auth()->user()->id ? 'text-gray-200' : 'text-gray-700' }}">
                                    {{ $message->created_at }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Message Input Form --}}
            <div class="p-4 bg-gray-200 rounded-b-lg">
                <form id="chat-form" method="POST" action="{{ route('chat.send') }}" class="flex space-x-2"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                    <textarea name="message" id="message"
                              class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                              placeholder="Type your message..." rows="2"></textarea>

                    <label for="image-upload"
                           class="cursor-pointer bg-gray-200 p-2 rounded-full hover:bg-gray-300 transition">
                        <i class="fas fa-image text-xl text-purple-500"></i>
                    </label>
                    <input type="file" name="image" id="image-upload" class="hidden" />

                    <button type="submit"
                            class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        // Delete Message Function
        function deleteMessage(messageId) {
            if (!confirm('Are you sure you want to delete this message?')) {
                return;
            }

            fetch(`/chat/delete/${messageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const messageElement = document.getElementById(`message-${messageId}`);
                        messageElement.remove();
                    } else {
                        alert('Failed to delete message');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting message');
                });
        }
    </script>
@endsection
