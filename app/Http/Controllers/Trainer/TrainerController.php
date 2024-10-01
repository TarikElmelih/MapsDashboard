<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
   

    public function dashboard()
    {
        $users = User::all();
        $averageCommitmentPoints = User::avg('commitment_points');
        $averageParticipationPoints = User::avg('participation_points');
        $averageTestPoints = User::avg('test_points');
        $averageProjectsCount = User::avg('projects_count');

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
        $user = User::findOrFail(1); 
        return view('admin.points', compact('user'));
    }
}
