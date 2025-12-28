<!-- resources/views/admin/team/create.blade.php -->
<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Team Member</h1>
        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('name') }}" required>
                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <input type="text" name="role" id="role" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('role') }}" required>
                @error('role') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" class="form-textarea w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" id="image" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('image') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('email') }}">
                @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" id="phone" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('phone') }}">
                @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                <input type="url" name="linkedin" id="linkedin" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('linkedin') }}">
                @error('linkedin') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                <input type="url" name="twitter" id="twitter" class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('twitter') }}">
                @error('twitter') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="text-right">
                <button type="submit" class="btn bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 transition duration-300">Add Team Member</button>
            </div>
        </form>
    </div>
</x-app-layout>
