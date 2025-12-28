@php
    use Illuminate\Support\Str;
@endphp
<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Custom CSS for enhanced UI */
        .chat-container {
            height: 800px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            background: #ffffff;
            border-radius: 12px 0 0 12px;
            transition: all 0.3s ease;
        }
        .sidebar li a {
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .sidebar li a:hover {
            transform: translateX(5px);
        }
        .chat-box {
            background: #ffffff;
            border-radius: 0 12px 12px 0;
            transition: all 0.3s ease;
        }
        .chat-header {
            background: linear-gradient(to right, #6b48ff, #8b5cf6);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .message-bubble {
            transition: all 0.2s ease;
        }
        .message-bubble:hover {
            transform: scale(1.02);
        }

        .input-form textarea {
            resize: none;
            transition: border-color 0.3s ease;
        }
        .input-form textarea:focus {
            border-color: #6b48ff;
            box-shadow: 0 0 8px rgba(107, 72, 255, 0.3);
        }
        .btn-send {
            background: #6b48ff;
        }
        .btn-send:hover {
            background: #5a3de6;
            transform: translateY(-2px);
        }
    </style>

    <div class="flex container mx-auto p-4 chat-container">
        <!-- Sidebar for Clients -->
        <div class="w-1/3 p-6 sidebar overflow-y-auto">
            <h5 class="font-bold mb-6 text-xl text-purple-800 tracking-wide">Clients</h5>
            <ul>
                @forelse ($clients as $client)
                    <li class="mb-3">
                        <a href="{{ route('freelancer.chat', $client->id) }}"
                           class="flex items-center p-4 bg-white rounded-xl shadow-md hover:bg-purple-50 {{ $otherUser && $otherUser->id == $client->id ? 'bg-purple-100 border-l-4 border-purple-500' : '' }}">
                            <img alt="{{ $client->name }}'s Profile Picture"
                                 class="w-12 h-12 rounded-full mr-4 border-2 border-purple-400 shadow-sm object-cover"
                                 src="{{ $client->profile_image ? asset('storage/' . $client->profile_image) : asset('images/default-avatar.png') }}"
                                 width="48" height="48" />
                            <div class="flex-1">
                                <p class="font-semibold text-purple-900 text-base">{{ $client->name }}</p>
                                @if ($client->sentMessages->isNotEmpty())
                                    <p class="text-sm text-gray-600 truncate">
                                        {{ Str::limit($client->sentMessages->first()->message, 30) }}
                                    </p>
                                    <p class="text-xs text-purple-500 mt-1">
                                        {{ $client->sentMessages->first()->created_at->format('d M') }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic">No messages yet</p>
                                @endif
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="text-gray-600 text-center py-4">No clients found.</li>
                @endforelse
            </ul>
        </div>

        <!-- Chat Box -->
        <div class="w-2/3 chat-box shadow-lg ml-4 flex flex-col">
            @if ($otherUser)
                <div class="chat-header text-white py-4 px-6 rounded-t-lg flex justify-between items-center">
                    <h4 class="text-xl font-semibold tracking-tight">{{ ucwords($otherUser->name) }}</h4>
                    <div class="space-x-4">
                        <i class="fas fa-camera text-purple-200 hover:text-white cursor-pointer"></i>
                        <i class="fas fa-arrow-right text-purple-200 hover:text-white cursor-pointer"></i>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="p-6 h-96 overflow-y-auto bg-gray-50" id="chat-box">
                    @forelse ($messages as $message)
                        <div id="message-{{ $message->id }}"
                             class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} my-3">
                            <div class="relative group">
                                @if ($message->sender_id == auth()->id())
                                    <div class="absolute right-2 top-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <button onclick="deleteMessage('{{ $message->id }}')"
                                                class="text-white hover:text-red-400 p-1 bg-purple-700 rounded-full">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                @endif
                                <div class="max-w-sm px-5 py-3 text-sm message-bubble {{ $message->sender_id == auth()->id() ? 'bg-purple-600 text-white rounded-l-xl rounded-br-xl' : 'bg-purple-100 text-purple-900 rounded-r-xl rounded-bl-xl' }} shadow-md">
                                    @if ($message->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $message->image) }}" alt="Image" class="max-w-xs rounded-lg shadow-sm">
                                        </div>
                                    @endif
                                    <p id="message-content-{{ $message->id }}">{{ $message->message }}</p>
                                    <small class="block text-xs mt-1 {{ $message->sender_id == auth()->id() ? 'text-purple-200' : 'text-purple-600' }}">
                                        {{ $message->sender_id == auth()->id() ? 'You' : 'Them' }} • {{ $message->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center mt-20">No messages yet. Start the conversation!</p>
                    @endforelse
                </div>

                <!-- Message Input Form -->
                <div class="p-6 bg-white border-t border-purple-200 rounded-b-lg input-form">
                    <form id="chat-form" method="POST" action="{{ route('chat.send') }}" class="flex space-x-3"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                        <textarea name="message" id="message"
                                  class="flex-grow p-3 border border-purple-200 rounded-xl focus:outline-none text-gray-800"
                                  placeholder="Type your message..." rows="2"></textarea>
                        <label for="image-upload"
                               class="cursor-pointer bg-purple-100 p-3 rounded-full hover:bg-purple-200 transition">
                            <i class="fas fa-camera text-xl text-purple-600"></i>
                        </label>
                        <input type="file" name="image" id="image-upload" class="hidden" />
                        <button type="submit"
                                class="btn-send text-white px-5 py-2 rounded-xl transition shadow-md">
                            <i class="fas fa-paper-plane text-purple-200 mr-2"></i> Send
                        </button>
                    </form>
                </div>
            @else
                <div class="h-full flex items-center justify-center bg-gray-50 rounded-b-lg">
                    <p class="text-gray-500 text-lg">Select a client to start chatting.</p>
                </div>
            @endif
        </div>
    </div>

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
</x-app-layout>