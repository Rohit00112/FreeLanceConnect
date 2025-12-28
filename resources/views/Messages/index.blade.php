<!-- resources/views/messages.blade.php -->
<!-- resources/views/messages.blade.php -->
<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #messages {
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .message {
            margin-bottom: 15px;
        }

        .message p {
            margin: 0;
            padding: 10px;
            border-radius: 5px;
        }

        .message.sender p {
            background-color: #e1f5fe;
            text-align: right;
        }

        .message.receiver p {
            background-color: #f1f1f1;
            text-align: left;
        }

        .alert {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Client Communication</h1>

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('messages.store') }}" method="POST">
            @csrf
            <div>
                <label for="receiver_id">To:</label>
                <input type="text" id="receiver_id" name="receiver_id" required>
            </div>
            <div>
                <label for="body">Message:</label>
                <textarea id="body" name="body" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>

        <div id="messages">
            <h2>Your Messages</h2>
            <div class="message sender">
                <p>Hi, can you update the homepage design?</p>
            </div>
            <div class="message receiver">
                <p>Sure, I'll work on it today.</p>
            </div>
            <div class="message sender">
                <p>Thanks! Let me know if you need any assets.</p>
            </div>
            <div class="message receiver">
                <p>Will do, I’ll keep you posted.</p>
            </div>
        </div>
    </div>
</body>
</html>
</x-app-layout>
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Your Messages</h3>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg h-full overflow-y-auto">
            @foreach ($messages as $message)
                <div class="mb-4">
                    <div class="flex items-start mb-2">
                        <div class="{{ $message->sender_id == auth()->id() ? 'bg-gray-300 dark:bg-gray-700' : 'bg-blue-500 text-white' }} p-2 rounded-lg max-w-xs">
                            <p class="text-sm">{{ $message->body }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $message->sender->name }}</span>
                </div>
            @endforeach
        </div>

        <form action="{{ route('messages.store') }}" method="POST" class="mt-4">
            @csrf
            <textarea name="body" class="w-full p-2 rounded-lg border border-gray-300 dark:border-gray-700" rows="2" placeholder="Type your message..."></textarea>
            <input type="hidden" name="receiver_id" value="1"> <!-- Set receiver_id dynamically -->
            <button class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Send</button>
        </form>
    </div>
</x-app-layout> --}}
<div class="message-list">
    @foreach($messages as $message)
        <div class="message-item" onclick="window.location='{{ route('chat.show', ['user' => $message->sender_id]) }}'">
            <h3>{{ $message->sender->name }}</h3>
            <p>{{ $message->body }}</p>
        </div>
    @endforeach
</div>

        </div>
    </div>
</body>
</html>
</x-app-layout>
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Your Messages</h3>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg h-full overflow-y-auto">
            @foreach ($messages as $message)
                <div class="mb-4">
                    <div class="flex items-start mb-2">
                        <div class="{{ $message->sender_id == auth()->id() ? 'bg-gray-300 dark:bg-gray-700' : 'bg-blue-500 text-white' }} p-2 rounded-lg max-w-xs">
                            <p class="text-sm">{{ $message->body }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $message->sender->name }}</span>
                </div>
            @endforeach
        </div>

        <form action="{{ route('messages.store') }}" method="POST" class="mt-4">
            @csrf
            <textarea name="body" class="w-full p-2 rounded-lg border border-gray-300 dark:border-gray-700" rows="2" placeholder="Type your message..."></textarea>
            <input type="hidden" name="receiver_id" value="1"> <!-- Set receiver_id dynamically -->
            <button class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Send</button>
        </form>
    </div>
</x-app-layout> --}}
