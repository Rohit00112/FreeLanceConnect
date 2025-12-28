<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Team Members</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.team.create') }}" class="bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-purple-700 transition-all duration-300">
                Add Member
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 rounded-lg shadow-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-4 border">Name</th>
                        <th class="py-3 px-4 border">Role</th>
                        <th class="py-3 px-4 border">Image</th>
                        <th class="py-3 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teamMembers as $member)
                    <tr class="text-center border-b hover:bg-gray-100 transition-all duration-300">
                        <td class="py-3 px-4 border">{{ $member->name }}</td>
                        <td class="py-3 px-4 border">{{ $member->role }}</td>
                        <td class="py-3 px-4 border">
                            <img src="{{ asset('storage/' . $member->image) }}" class="w-12 h-12 rounded-full object-cover mx-auto">
                        </td>
                        <td class="py-3 px-4 border flex justify-center space-x-2">
                            <a href="{{ route('admin.team.edit', $member->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-all">
                                Edit
                            </a>
                            <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-all">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-gray-500 text-center">No team members found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
