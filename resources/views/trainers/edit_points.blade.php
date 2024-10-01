@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-100 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Edit User Points</h2>
        </div>
        
        <form action="{{ route('trainer.updatePoints', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="commitment_points" class="block text-sm font-medium text-gray-700 mb-2">Commitment Points</label>
                <input type="number" name="commitment_points" id="commitment_points" value="{{ $user->commitment_points }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="mb-4">
                <label for="participation_points" class="block text-sm font-medium text-gray-700 mb-2">Participation Points</label>
                <input type="number" name="participation_points" id="participation_points" value="{{ $user->participation_points }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="mb-4">
                <label for="test_points" class="block text-sm font-medium text-gray-700 mb-2">Test Points</label>
                <input type="number" name="test_points" id="test_points" value="{{ $user->test_points }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="mb-6">
                <label for="projects_count" class="block text-sm font-medium text-gray-700 mb-2">Number of Projects</label>
                <input type="number" name="projects_count" id="projects_count" value="{{ $user->projects_count }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Points
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
