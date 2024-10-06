@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-4">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4">
            {{ $errors->first('file') }}
        </div>
    @endif
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg mt-8 mb-8">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-800 mb-6">Your Points</h2>
        <div id="user-points" class="mt-4"></div>
        <div id="error-message" class="text-red-600 mt-2"></div>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-800 mb-6">Upload Your Documents</h2>
        <form action="{{ route('user.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="mb-5">
                <label for="file_type" class="block text-sm font-bold text-gray-600 mb-2">File Type:</label>
                <select name="file_type" id="file_type" class="block w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required onchange="updateInputField(this.value)">
                    <option value="CV">CV</option>
                    <option value="Cover Letter">Cover Letter</option>
                    <option value="Career Plan">Career Plan</option>
                    <option value="LinkedIn">LinkedIn</option>
                    <option value="E-Mail Writing">E-Mail Writing</option>
                    <option value="Presentation">Presentation</option>
                    <option value="Portfolio">Portfolio</option>
                </select>
            </div>
            
            <div id="file_input_div" class="mb-5">
                <input type="file" name="file" class="block w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white font-semibold px-5 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md hover:bg-blue-600 transition ease-in-out duration-150">
                    Upload
                </button>
            </div>
        </form>
    </div>

    <script>
        function updateInputField(fileType) {
            const fileInputDiv = document.getElementById('file_input_div');
            if (fileType === 'LinkedIn' || fileType === 'Portfolio') {
                fileInputDiv.innerHTML = '<input type="url" name="file" class="block w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-md" placeholder="Enter URL" required>';
            } else {
                fileInputDiv.innerHTML = '<input type="file" name="file" class="block w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-md" required>';
            }
        }
    </script>

    <div class="mt-8 bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold mb-4 text-gray-800">Uploaded Files</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white rounded-md border border-gray-200 shadow-sm">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-sm font-bold text-gray-600">File Type</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-sm font-bold text-gray-600">Status</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-sm font-bold text-gray-600">Comments</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(auth()->user()->files)
                        @foreach(auth()->user()->files as $file)
                            <tr>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    {{ $file->file_type }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $file->status == 'pending' ? 'bg-red-100 text-red-600' : ($file->status == 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600') }}">
                                        {{ ucfirst($file->status) }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    {{ $file->comment }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="px-4 sm:px-6 py-4 text-center text-gray-500">
                                No files uploaded yet.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    

    <script>
        const sheetId = '16N1xYDpd8lzD9VMykNlitts-0N13L0nc6pjnw2LiEyk';
        const apiKey = 'AIzaSyAPo5BNoRy4V-sakFpG0COSSbn6AZyCbL0';
        const range = 'التقييم!A1:D46';
        const userId = '{{ auth()->user()->id }}'; // Get the current user's ID

        const url = `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/${encodeURIComponent(range)}?key=${apiKey}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.values || data.values.length === 0) {
                    throw new Error('No data found in the sheet');
                }
                const rows = data.values;
                const userRow = rows.find(row => row[0] === '{{ Auth::user()->code }}');
                
                if (userRow) {
                    let html = '<table class="min-w-full table-auto bg-white rounded-md border border-gray-200 shadow-sm">';
                    html += '<thead class="bg-blue-100"><tr>';
                    html += '<th class="px-4 sm:px-6 py-3 text-left text-sm font-bold text-gray-600">ID</th>';
                    html += '<th class="px-4 sm:px-6 py-3 text-left text-sm font-bold text-gray-600">Name</th>';
                    html += '<th class="px-4 sm:px-6 py-3 text-left text-sm font-bold text-gray-600">Points</th>';
                    html += '</tr></thead><tbody class="bg-white divide-y divide-gray-200">';
                    html += '<tr>';
                    html += `<td class="px-4 sm:px-6 py-4 whitespace-nowrap">${userRow[0]}</td>`; // ID
                    html += `<td class="px-4 sm:px-6 py-4 whitespace-nowrap">${userRow[1]}</td>`; // Name
                    html += `<td class="px-4 sm:px-6 py-4 whitespace-nowrap">${userRow[3]}</td>`; // Points
                    html += '</tr>';
                    html += '</tbody></table>';
                    document.getElementById('user-points').innerHTML = html;
                } else {
                    document.getElementById('user-points').innerHTML = '<p class="text-gray-600">No points data found for your account.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'An error occurred while fetching data.';
                if (error.message.includes('403')) {
                    errorMessage = 'Access to the Google Sheet is forbidden. Please contact an administrator.';
                } else if (error.message.includes('404')) {
                    errorMessage = 'The specified Google Sheet could not be found. Please contact an administrator.';
                }
                document.getElementById('error-message').textContent = errorMessage;
            });
    </script>
</div>
@endsection
