@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 mt-9 ml-10 mr-10">Edit User Details</h1>

    <!-- Edit User Form -->
    <form action="{{ route('admin.usersDetails.update', $users->id) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-md ml-10 mr-10 mb-10">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div>
            <label for="name" class="block font-semibold text-gray-700">Name:</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ $users->name }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block font-semibold text-gray-700">Email:</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ $users->email }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- Code Field -->
        <div>
            <label for="code" class="block font-semibold text-gray-700">Code:</label>
            <input 
                type="text" 
                id="code" 
                name="code" 
                value="{{ $users->code }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>
        <!-- Role Field -->
        <div>
            <label for="role" class="block font-semibold text-gray-700">Role:</label>
            <input 
                type="text" 
                id="role" 
                name="role" 
                value="{{ $users->is_admin ? 'Admin' : 'User' }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- Trainer Field -->
        <div>
            <label for="trainer" class="block font-semibold text-gray-700">Trainer:</label>
            <input 
                type="text" 
                id="trainer" 
                name="trainer" 
                value="{{ $users->trainer }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- Training Type Field -->
        <div>
            <label for="training" class="block font-semibold text-gray-700">Training Type:</label>
            <input   
                type="text" 
                id="training" 
                name="training" 
                value="{{ $users->training }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>  

        <!-- Facilator Field -->
        <div>
            <label for="facilitator" class="block font-semibold text-gray-700">Facilator:</label>
            <input 
                type="text" 
                id="facilitator" 
                name="facilitator" 
                value="{{ $users->facilitator }}" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>


        
        <!-- Password Field -->
        <div>
            <label for="password" class="block font-semibold text-gray-700">Password:</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- Update Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Update User
            </button>
        </div>
    </form>
@endsection
