<li>
    <a href="{{ route('projects.index') }}"
       class="flex items-center p-2 rounded {{ request()->routeIs('projects.*') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"></path>
        </svg>
        <span class="ml-2">Projects</span>
    </a>
</li>
<li>
    <a href="{{ route('clients.index') }}" class="flex items-center p-2 rounded {{ request()->routeIs('clients.*') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M3 6h18M3 14h18m-9 4h9"></path>
        </svg>
        <span class="ml-2">clients Proposals</span>
    </a>
</li>

<li>
    <a href="{{ route('freelancer.todolist') }}" class="flex items-center p-2 rounded {{ request()->routeIs('todolist.*') ? 'bg-[#6A45C4]' : 'hover:bg-[#6A45C4]' }}">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
        <span class="ml-2">To-Do List</span>
    </a>
</li>
<li>
    <a href="/freelancer/chat/2" class="flex items-center p-2 rounded hover:bg-[#6A45C4]">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
        <span class="ml-2">Message</span>
    </a>
</li>



