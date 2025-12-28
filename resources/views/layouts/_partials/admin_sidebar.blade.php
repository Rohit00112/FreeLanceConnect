<li>
    <a href="{{ route('admin.users.index') }}"
       class="flex items-center p-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"></path>
        </svg>
        <span class="ml-2">Users</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.payments.index') }}"
       class="flex items-center p-2 rounded {{ request()->routeIs('admin.payments.*') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 8.25H9m6 3H9m3 6-3-3h1.5a3 3 0 1 0 0-6M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="ml-2">Payments</span>
    </a>
</li>