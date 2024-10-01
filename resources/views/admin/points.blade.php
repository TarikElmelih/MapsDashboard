@extends('layouts.app')

@section('content')
<div class="bg-white p-3 sm:p-4 rounded-lg shadow-md mb-8 mx-4 sm:mx-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">User Points Overview</h2>
    
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Search by points..." class="border rounded-md p-2 w-full" onkeyup="filterTable()">
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto" id="pointsTable">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Name</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Commitment Points</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Participation Points</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Test Points</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Projects Count</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b">
                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->name }}</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->commitment_points }}</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->participation_points }}</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->test_points }}</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">{{ $user->projects_count }}</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-sm">
                        <a href="{{ route('admin.editPoints', $user->id) }}" class="text-blue-500 hover:underline">Edit Points</a>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const table = document.getElementById("pointsTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const commitmentCell = row.getElementsByTagName("td")[0];
            const participationCell = row.getElementsByTagName("td")[1];
            const testCell = row.getElementsByTagName("td")[2];
            const projectsCell = row.getElementsByTagName("td")[3];

            if (commitmentCell || participationCell || testCell || projectsCell) {
                const commitment = commitmentCell.textContent.toLowerCase();
                const participation = participationCell.textContent.toLowerCase();
                const test = testCell.textContent.toLowerCase();
                const projects = projectsCell.textContent.toLowerCase();
                if (commitment.includes(input) || participation.includes(input) || test.includes(input) || projects.includes(input)) {
                    row.style.display = ""; // Show row
                } else {
                    row.style.display = "none"; // Hide row
                }
            }
        }
    }
</script>
@endsection
