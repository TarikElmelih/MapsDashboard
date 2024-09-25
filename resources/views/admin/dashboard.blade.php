@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 mt-6 mx-4 sm:mx-6">Admin Dashboard</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mx-4 sm:mx-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow-md">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Total Users</h2>
            <p class="text-2xl sm:text-3xl font-bold text-blue-500">{{ $totalUsers }}</p>
        </div>

        <!-- Completed Profiles -->
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow-md">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Completed Profiles</h2>
            <p class="text-2xl sm:text-3xl font-bold text-green-500">{{ $completedProfiles }}</p>
        </div>

        <!-- Pending Profiles -->
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow-md">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Pending Profiles</h2>
            <p class="text-2xl sm:text-3xl font-bold text-yellow-500">{{ $pendingProfiles }}</p>
        </div>

        <!-- Not Sufficient Profiles -->
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow-md">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Not Sufficient Profiles</h2>
            <p class="text-2xl sm:text-3xl font-bold text-red-500">{{ $notSufficientProfiles }}</p>
        </div>
    </div>

    <!-- User List Table -->
    <div class="bg-white p-3 sm:p-4 rounded-lg shadow-md mb-8 mx-4 sm:mx-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">User Details</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Code</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Completed Files</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Pending Files</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Not Sufficient Files</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b">
                            <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->code }}</td>
                            <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->files->where('status', 'completed')->count() }}</td>
                            <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->files->where('status', 'pending')->count() }}</td>
                            <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->files->where('status', 'not_sufficient')->count() }}</td>
                            <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">
                                <a href="{{ route('admin.usersDetails', $user->id) }}" class="text-blue-500 hover:underline">View Profile</a> |
                                <a href="{{ route('admin.usersDetails.edit', $user->id) }}" class="text-green-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-3 sm:p-4 rounded-lg shadow-md mx-4 sm:mx-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Profile Status Breakdown</h2>
        <div class="relative w-full h-72">
            <canvas id="profileStatusChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('profileStatusChart').getContext('2d');
        const profileStatusChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Completed', 'Pending', 'Not Sufficient'],
                datasets: [{
                    label: 'Profile Status',
                    data: [{{ $completedProfiles }}, {{ $pendingProfiles }}, {{ $notSufficientProfiles }}],
                    backgroundColor: ['#38A169', '#ECC94B', '#F56565'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10, // Adjusted for mobile view
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10, // Adjusted for mobile view
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
