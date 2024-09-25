<div class="bg-blue-900 min-h-screen md:w-64 w-full p-6 text-white hidden md:block">
   
        <h1 class="text-2xl font-bold mb-10">
             TVET ASB
        </h1>
    
    <nav class="space-y-4">
        @if (auth()->user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700 transition text-white">
            <i class="fas fa-user mr-2"></i> Dashboard
        </a>
        @else
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700 transition text-white">
            <i class="fas fa-home mr-2"></i> Dashboard
        </a>
        @endif
        @if (auth()->user()->is_admin)
        <a href="{{ route('admin.users') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700 transition text-white">
            <i class="fas fa-user mr-2"></i> Trainees
        </a>
        @endif
        @if (auth()->user()->is_admin)
        <a href="{{ route('admin.usersDetails') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700 transition text-white">
            <i class="fas fa-user mr-2"></i> Users
        </a>
        @endif
        <a href="{{ route('profile.index') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700 transition text-white">
            <i class="fas fa-user mr-2"></i> Profile
        </a>
    </nav>

    <!-- Space before Logout Button -->
    <div class="mt-10"></div>

    <!-- Logout Button at the end of the sidebar -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block py-2 px-4 rounded-lg hover:bg-blue-700 transition text-white">
            <i class="fas fa-sign-out-alt mr-2"></i> Log Out
        </button>
    </form>
    
</div>
