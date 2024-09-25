@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 mt-9 ml-10 mr-10">User Details</h1>

    <!-- Search Bar -->
    <div class="mb-4 mt-9 ml-10 mr-10">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for users..." class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
    </div>

    <!-- Responsive Table Container -->
    <div class="overflow-x-auto mb-6 ml-10 mr-10">
        <table id="userTable" class="min-w-full bg-white rounded-lg shadow-md overflow-hidden ">
            <thead>
                <tr class="bg-blue-500 text-white hidden md:table-row">
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Code</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Profile Status</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody >
                @foreach($users as $user)
                    @php
                        $completedFiles = $user->files->where('status', 'completed')->count();
                        $pendingFiles = $user->files->where('status', 'pending')->count();
                        $notSufficientFiles = $user->files->where('status', 'not_sufficient')->count();
                        $totalFiles = $user->files->count();
                    @endphp
                    <tr class="md:table-row border-b block md:border-none mb-4"> <!-- Added margin-bottom for spacing -->
                        <!-- Name -->
                        <td class="py-4 px-4 block md:table-cell">
                            <span class="inline-block w-1/3 font-bold md:hidden">Name:</span>
                            {{ $user->name }}
                        </td>

                        <!-- Code -->
                        <td class="py-4 px-4 block md:table-cell">
                            <span class="inline-block w-1/3 font-bold md:hidden">Code:</span>
                            {{ $user->code }}
                        </td>

                        <!-- Email -->
                        <td class="py-4 px-4 block md:table-cell">
                            <span class="inline-block w-1/3 font-bold md:hidden">Email:</span>
                            {{ $user->email }}
                        </td>

                        <!-- Profile Status -->
                        <td class="py-4 px-4 block md:table-cell">
                            <span class="inline-block w-1/3 font-bold md:hidden">Profile Status:</span>
                            @if($completedFiles === $totalFiles && $totalFiles > 0)
                                <span class="text-green-600 font-bold">✔ Completed</span>
                            @elseif($totalFiles === 0)
                                <span class="text-gray-500">No Files Uploaded</span>
                            @else
                                <span class="text-gray-600">Completed: {{ $completedFiles }}, Pending: {{ $pendingFiles }}, Not Sufficient: {{ $notSufficientFiles }}</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-4 block md:table-cell">
                            <span class="inline-block w-1/3 font-bold md:hidden">Actions:</span>
                            <div class="flex space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.usersDetails.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <!-- View Profile Button -->
                                <a href="{{ route('admin.usersDetails.show', $user->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                    View Profile
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function filterTable() {
            // Get the search input value
            const input = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("userTable");
            const rows = table.getElementsByTagName("tr");

            // Loop through all rows of the table (skip the header row)
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const nameCell = row.getElementsByTagName("td")[0];
                const codeCell = row.getElementsByTagName("td")[1];
                const emailCell = row.getElementsByTagName("td")[2];
                if (nameCell || codeCell || emailCell) {
                    const name = nameCell.textContent.toLowerCase();
                    const code = codeCell.textContent.toLowerCase();
                    const email = emailCell.textContent.toLowerCase();
                    if (name.includes(input) || code.includes(input) || email.includes(input)) {
                        row.style.display = ""; // Show row
                    } else {
                        row.style.display = "none"; // Hide row
                    }
                }
            }
        }
    </script>
@endsection
