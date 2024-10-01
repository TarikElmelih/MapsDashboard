@extends('layouts.app')

@section('content')
    <!-- Search Bar -->
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6 mt-9 mx-4 lg:mx-10 space-y-4 lg:space-y-0">
        <form action="{{ route('admin.users') }}" method="GET" class="flex w-full lg:w-auto">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Search by name or code..." 
                class="flex-grow lg:flex-none p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Search</button>
        </form>
        <!-- Filter Dropdown -->
        <form action="{{ route('admin.users') }}" method="GET" class="w-full lg:w-auto">
            <select name="filter" class="w-full p-2 border border-gray-300 rounded-md" onchange="this.form.submit()">
                <option value="">All Profiles</option>
                <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed Profiles</option>
                <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending Profiles</option>
                <option value="not_sufficient" {{ request('filter') == 'not_sufficient' ? 'selected' : '' }}>Not Sufficient Profiles</option>
            </select>
        </form>
    </div>

    <!-- User List -->

    <div class="space-y-4 mb-6 mx-4 lg:mx-10">
        @foreach($users as $user)
            <div class="bg-white p-4 rounded-md shadow-md">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $user->name }} (Code: {{ $user->code }})</h3>
                        @php
                            $completedFiles = $user->files->where('status', 'completed')->count();
                            $pendingFiles = $user->files->where('status', 'pending')->count();
                            $notSufficientFiles = $user->files->where('status', 'not_sufficient')->count();
                            $totalFiles = $user->files->count();
                        @endphp
                        @if($completedFiles === $totalFiles && $totalFiles > 0)
                            <span class="text-green-600 font-bold">✔ Completed</span>
                        @elseif($completedFiles > 0 || $pendingFiles > 0 || $notSufficientFiles > 0)
                            <span class="text-gray-600">Completed: {{ $completedFiles }}, Pending: {{ $pendingFiles }}, Not Sufficient: {{ $notSufficientFiles }}</span>
                        @else
                            <span class="text-gray-600">No files uploaded</span>
                        @endif
                    </div>
                    <button class="mt-4 md:mt-0 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="toggleDetails({{ $user->id }})">
                        View Details
                    </button>
                </div>

                <!-- User File Details (Initially Hidden) -->
                <div id="user-{{ $user->id }}" class="hidden mt-4">
                    <ul class="space-y-2">
                        @foreach($user->files as $file)
                            <li class="flex justify-between items-center">
                                <span>{{ $file->file_type }} - Status: {{ $file->status }}</span>
                                <div class="flex items-center space-x-2">
                                    @if($file->file_type === 'LinkedIn')
                                        <a href="{{ $file->file_path }}" target="_blank" class="text-blue-500 hover:underline">View</a>
                                    @else
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-500 hover:underline">View</a>
                                    @endif
                                    <form action="{{ route('admin.review', $file->id) }}" method="POST" class="flex">
                                        @csrf
                                        <select name="status" class="p-1 border border-gray-300 rounded-md">
                                            <option value="completed" {{ $file->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="pending" {{ $file->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="not_sufficient" {{ $file->status == 'not_sufficient' ? 'selected' : '' }}>Not Sufficient</option>
                                        </select>
                                        <textarea name="comment" class="p-1 border border-gray-300 rounded-md ml-2">{{ $file->comment }}</textarea>
                                        <button type="submit" class="ml-2 bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600 transition">Update</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <!-- JavaScript for Toggle -->
    <script>
        function toggleDetails(userId) {
            const detailsDiv = document.getElementById(`user-${userId}`);
            if (detailsDiv.classList.contains('hidden')) {
                detailsDiv.classList.remove('hidden');
            } else {
                detailsDiv.classList.add('hidden');
            }
        }
    </script>
@endsection