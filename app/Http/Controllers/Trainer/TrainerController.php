<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
   

    public function dashboard()
    {
        $trainer = auth()->user();
        $users = $trainer->trainees()->where('training_type', $trainer->training_type)->get();
        
        $averageCommitmentPoints = $users->avg('commitment_points');
        $averageParticipationPoints = $users->avg('participation_points');
        $averageTestPoints = $users->avg('test_points');
        $averageProjectsCount = $users->avg('projects_count');

        return view('trainers.dashboard', compact(
            'users', 'averageCommitmentPoints', 'averageParticipationPoints', 'averageTestPoints', 'averageProjectsCount'
        ));
    }

    public function editPoints($id)
    {
        $user = User::findOrFail($id);
        return view('trainers.edit_points', compact('user'));
    }

    public function updatePoints(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['commitment_points', 'participation_points', 'test_points', 'projects_count']));
        return redirect()->route('trainer.dashboard')->with('success', 'User points updated successfully');
    }

    public function points()
    {
        $trainer = auth()->user();
        $users = $trainer->trainees()->where('training_type', $trainer->training_type)->get();
        return view('trainers.points', compact('users'));
    }
}
