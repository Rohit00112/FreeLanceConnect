<x-app-layout>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-[#7F55E0] text-white flex flex-col">
            <div class="py-6 px-4">
                <h1 class="text-2xl font-bold">Freelancer</h1>
            </div>
            <nav class="flex-grow">
                <ul class="space-y-2 px-4">
                    <!-- Sidebar Items -->
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>
                    <!-- Other sidebar items... -->
                    <li>
                        <a href="{{ route('projects') }}"
                            class="flex items-center p-2 rounded {{ request()->routeIs('projects') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="ml-2">Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('clients.index') }}" class="flex items-center p-2 rounded hover:bg-[#6A45C4]">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M3 6h18M3 14h18m-9 4h9"></path>
                            </svg>
                            <span class="ml-2">Client</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-[#6A45C4]">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span class="ml-2">Message</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-[#6A45C4]">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M3 6h18M3 14h18m-9 4h9"></path>
                            </svg>
                            <span class="ml-2">Setting</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-[#6A45C4]">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v12l3-3 4 4 5-5 3 3V3"></path>
                            </svg>
                            <span class="ml-2">Profile</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-gray-100">
            <h1 class="text-2xl font-semibold mb-6">{{ isset($client) ? 'Edit Client' : 'Add Client' }}</h1>

            <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" method="POST" class="max-w-4xl mx-auto p-6 border border-gray-300 rounded-lg shadow-lg bg-white">
                @csrf
                @if(isset($client))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ $client->name ?? '' }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ $client->email ?? '' }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ $client->phone ?? '' }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" value="{{ $client->address ?? '' }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    {{ isset($client) ? 'Update' : 'Add' }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
