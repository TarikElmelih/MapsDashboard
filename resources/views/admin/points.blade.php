@extends('layouts.app')

@section('content')

<div class="bg-white p-3 sm:p-4 rounded-lg shadow-md mb-8 mx-4 sm:mx-6 mt-6">
    <h1 class="text-2xl font-bold mt-8 mb-4">Monthly Points</h1>

    <!-- Training Type Filter Dropdown -->
    <div class="mb-4">
        <label for="training-select" class="block mb-2 text-sm font-medium text-gray-700">Select Training Type:</label>
        <select id="training-select" class="block w-full p-2 border border-gray-300 rounded-md">
            <option value="Backend">Backend</option>
            <option value="Frontend">Frontend</option>
            <option value="Graphic">Graphic</option>
        </select>
    </div>

    <!-- Month Filter Dropdown -->
    <div class="mb-4">
        <label for="month-select" class="block mb-2 text-sm font-medium text-gray-700">Select Month:</label>
        <select id="month-select" class="block w-full p-2 border border-gray-300 rounded-md">
            <option value="Month 1">Month 1</option>
            <option value="Month 2">Month 2</option>
            <option value="Month 3">Month 3</option>
            <option value="Month 4">Month 4</option>
            <option value="Month 5">Month 5</option>
            <option value="Month 6">Month 6</option>
        </select>
    </div>

    <div id="student-totals" class="overflow-x-auto"></div>
    <div id="error-message" class="text-red-600"></div>

    <script>
        const apiKey = 'AIzaSyAPo5BNoRy4V-sakFpG0COSSbn6AZyCbL0';

        const sheetIds = {
            'Backend': '16N1xYDpd8lzD9VMykNlitts-0N13L0nc6pjnw2LiEyk',
            'Frontend': '1NNVD6DNdTgahs5V__fA4nbkkSR3Gggn53CaYXhUnhTc',
            'Graphic': '1d55OQEMM6Yly4ZA8pDbOFJrPqlFQPsa6vVWtJqpfe4E'
        };

        const fixedRange = 'الاجمالي!A1:B47';  // ID and Name columns only
        const monthRanges = {
            'Month 1': 'الاجمالي!C1:I47',  // Dynamic data for Month 1
            'Month 2': 'الاجمالي!J1:P47',  // Dynamic data for Month 2
            'Month 3': 'الاجمالي!Q1:W47',  // Dynamic data for Month 3
            'Month 4': 'الاجمالي!X1:AD47', // Dynamic data for Month 4
            'Month 5': 'الاجمالي!AE1:AK47', // Dynamic data for Month 5
            'Month 6': 'الاجمالي!AL1:AR47'  // Dynamic data for Month 6
        };

        let selectedTraining = 'Backend';  // Default training type
        let fixedData = [];

        // Fetch ID and Name (fixed data)
        function fetchFixedData(sheetId) {
            const url = `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/${encodeURIComponent(fixedRange)}?key=${apiKey}`;
            return fetch(url)
                .then(response => response.json())
                .then(data => data.values);
        }

        // Fetch dynamic data based on the selected month and training
        function fetchDynamicData(sheetId, month) {
            const range = monthRanges[month];
            const url = `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/${encodeURIComponent(range)}?key=${apiKey}`;
            return fetch(url)
                .then(response => response.json())
                .then(data => data.values);
        }

        // Render table
        function renderTable(fixedData, dynamicData) {
            let tableHTML = `
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Attendance</th>
                            <th class="border px-4 py-2">Participation</th>
                            <th class="border px-4 py-2">Monthly Project</th>
                            ${selectedTraining === 'Backend' ? '<th class="border px-4 py-2">Total Tasks</th>' : ''}
                            <th class="border px-4 py-2">Monthly Test</th>
                            <th class="border px-4 py-2">Excellence Points</th>
                            <th class="border px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            for (let i = 1; i < fixedData.length; i++) {  // Assuming first row is header
                const fixedRow = fixedData[i];
                const dynamicRow = dynamicData[i];

                tableHTML += `
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">${fixedRow[0]}</td>   <!-- ID -->
                        <td class="border px-4 py-2">${fixedRow[1]}</td>   <!-- Name -->
                        <td class="border px-4 py-2">${dynamicRow[0]}</td> <!-- Attendance -->
                        <td class="border px-4 py-2">${dynamicRow[1]}</td> <!-- Participation -->
                        <td class="border px-4 py-2">${dynamicRow[2]}</td> <!-- Monthly Project -->
                        ${selectedTraining === 'Backend' ? `<td class="border px-4 py-2">${dynamicRow[3]}</td>` : ''} <!-- Total Tasks -->
                        <td class="border px-4 py-2">${dynamicRow[selectedTraining === 'Backend' ? 4 : 3]}</td> <!-- Monthly Test -->
                        <td class="border px-4 py-2">${dynamicRow[selectedTraining === 'Backend' ? 5 : 4]}</td> <!-- Excellence Points -->
                        <td class="border px-4 py-2">${dynamicRow[selectedTraining === 'Backend' ? 6 : 5]}</td> <!-- Total -->
                    </tr>
                `;
            }

            tableHTML += '</tbody></table>';
            document.getElementById('student-totals').innerHTML = tableHTML;
        }

        // Initial load: Fetch and render fixed data, then load first month's dynamic data for Backend
        fetchFixedData(sheetIds[selectedTraining]).then(data => {
            fixedData = data;
            fetchDynamicData(sheetIds[selectedTraining], 'Month 1').then(dynamicData => {
                renderTable(fixedData, dynamicData);
            });
        });

        // Handle training selection change
        document.getElementById('training-select').addEventListener('change', function () {
            selectedTraining = this.value;
            fetchFixedData(sheetIds[selectedTraining]).then(data => {
                fixedData = data;
                fetchDynamicData(sheetIds[selectedTraining], 'Month 1').then(dynamicData => {
                    renderTable(fixedData, dynamicData);
                });
            });
        });

        // Handle month selection change
        document.getElementById('month-select').addEventListener('change', function () {
            const selectedMonth = this.options[this.selectedIndex].text;
            fetchDynamicData(sheetIds[selectedTraining], selectedMonth).then(dynamicData => {
                renderTable(fixedData, dynamicData);
            });
        });
    </script>
</div>

@endsection
