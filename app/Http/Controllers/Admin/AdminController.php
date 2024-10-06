<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserFile;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with('files')->get();
                
        // Calculate total counts
        $totalUsers = $users->count();
        $completedProfiles = 0;
        $pendingProfiles = 0;
        $notSufficientProfiles = 0;
    
        foreach ($users as $user) {
            $totalFiles = $user->files->count();
            $completedFiles = $user->files->where('status', 'completed')->count();
            $pendingFiles = $user->files->where('status', 'pending')->count();
            $notSufficientFiles = $user->files->where('status', 'not_sufficient')->count();
            
            if ($completedFiles === $totalFiles && $totalFiles > 0) {
                $completedProfiles++;
            } elseif ($pendingFiles > 0) {
                $pendingProfiles++;
            } elseif ($notSufficientFiles > 0) {
                $notSufficientProfiles++;
            }
        }
        
        $averageCommitmentPoints = User::avg('commitment_points');
        $averageParticipationPoints = User::avg('participation_points');
        $averageTestPoints = User::avg('test_points');
        $averageProjectsCount = User::avg('projects_count');
    
        return view('admin.dashboard', compact(
            'users', 'totalUsers', 'completedProfiles', 'pendingProfiles', 'notSufficientProfiles',
            'averageCommitmentPoints', 'averageParticipationPoints', 'averageTestPoints', 'averageProjectsCount'
        ));
    }
    
    public function index(Request $request)
    {
        $query = User::with('files');
    
        // Search by name or code
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('code', 'LIKE', '%' . $request->search . '%');
        }
    
        // Filter by profile completion status
        if ($request->has('filter')) {
            if ($request->filter == 'completed') {
                $query->whereHas('files', function($q) {
                    $q->where('status', 'completed');
                });
            } elseif ($request->filter == 'pending') {
                $query->whereHas('files', function($q) {
                    $q->where('status', 'pending');
                });
            } elseif ($request->filter == 'not_sufficient') {
                $query->whereHas('files', function($q) {
                    $q->where('status', 'not_sufficient');
                });
            }
        }
    
        $users = $query->get();
    
        return view('admin.users', compact('users'));
    }

    public function review(Request $request, $id)
    {
        $file = UserFile::find($id);
        $file->status = $request->status;
        $file->comment = $request->comment;
        $file->save();

        return back()->with('success', 'File reviewed');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.usersDetails', compact('users'));
    }

    public function edit($id)
    {
        $users = User::find($id);
        return view('admin.edit', compact('users'));
    }   

    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->update($request->all());
        return view('admin.edit', compact('users')); 
    }

    public function delete($id)
    {
        $users = User::find($id);
        $users->delete();
        return view('admin.usersDetails', compact('users')); 
    }

    public function show($id)
    {
        $users = User::find($id);
        return view('admin.show', compact('users'));
    }

    public function editPoints($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_points', compact('user'));
    }

    public function updatePoints(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['commitment_points', 'participation_points', 'test_points', 'projects_count']));
        return redirect()->route('admin.usersDetails')->with('success', 'User points updated successfully');
    }

    public function points()
    {
        $users = User::all(); 
        $lastFiveFiles = UserFile::with('user')->orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.points', compact('users', 'lastFiveFiles'));
    }
}
