<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Manage Users</h1>
            <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Add New User</a>
        </div>

        <!-- Filter Dropdown -->
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-4">
                <label for="role" class="font-semibold">Filter by Role:</label>
                <select name="role" id="role" class="border rounded px-4 py-2" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Clients</option>
                    <option value="freelancer" {{ request('role') == 'freelancer' ? 'selected' : '' }}>Freelancers</option>
                </select>
            </form>
        </div>

        <!-- Users Table -->
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">Name</th>
                    <th class="py-2 px-4 border">Email</th>
                    <th class="py-2 px-4 border">Role</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="py-2 px-4 border">{{ $user->name }}</td>
                        <td class="py-2 px-4 border">{{ $user->email }}</td>
                        <td class="py-2 px-4 border">{{ ucfirst($user->role->value) }}</td>

                        <td class="py-2 px-4 border">
                            @if(!$user->isAdmin())
                                <a href="{{ route('admin.users.edit', $user) }}" class=" bg-blue-600 text-white px-4 py-2 rounded inline-block leading-4">Edit</a>
                            @endif
                            @if(auth()->user()->id !== $user->id && !$user->isAdmin())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->appends(['role' => request('role')])->links() }}
        </div>
    </div>
</x-app-layout>
