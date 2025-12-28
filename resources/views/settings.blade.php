<!-- resources/views/messages/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Messages</h3>
        <!-- Add messages list and features like compose message, reply, etc. -->
    </div>
</x-app-layout>
