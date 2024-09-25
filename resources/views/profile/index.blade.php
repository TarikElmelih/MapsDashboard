@extends('layouts.app')

@section('content')
    <!-- Flex Container for Sidebar and Content -->
    <div class="flex flex-col lg:flex-row">
        <!-- Main Content -->
        <main class="flex-1 bg-white p-4 sm:p-6 rounded-lg shadow-lg lg:ml-16 mt-6 mb-16 mx-4 sm:mx-6 lg:mx-16">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Profile</h2>
            <!-- Details Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">{{ Auth::user()->name }}</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">{{ Auth::user()->email }}</p>
                </div>

                <!-- Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Code</label>
                    <p class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">{{ Auth::user()->code }}</p>
                </div>

                <!-- Training Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Training Type</label>
                    <p class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">{{ Auth::user()->training }}</p>
                </div>

                <!-- Trainer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Trainer</label>
                    <p class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">{{ Auth::user()->trainer }}</p>
                </div>

                <!-- Facilitator -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Facilitator</label>
                    <p class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">{{ Auth::user()->facilitator }}</p>
                </div>
            </div>

           
        </main>
    </div>
@endsection
