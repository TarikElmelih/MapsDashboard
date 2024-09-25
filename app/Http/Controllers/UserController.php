<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_type' => 'required|in:' . implode(',', UserFile::ALLOWED_FILE_TYPES),
            'file' => 'required',
        ]);

        // Check if the user has already uploaded a file of this type
        $existingFile = UserFile::where('user_id', Auth::id())
                                ->where('file_type', $request->file_type)
                                ->first();

        if ($existingFile) {
            return Redirect::back()->withErrors(['file' => 'You can only upload one ' . $request->file_type . ' file.']);
        }

        $filePath = '';
        if ($request->file_type === 'LinkedIn' || $request->file_type === 'Portfolio') {
            $filePath = $request->file;
        } else {
            $file = $request->file('file');
            $filePath = $file->store('user_files', 'public');
        }

        try {
            UserFile::create([
                'user_id' => Auth::id(),
                'file_type' => $request->file_type,
                'file_path' => $filePath,
                'status' => 'pending',
            ]);

            return Redirect::back()->with('success', 'File uploaded successfully.');
        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            return Redirect::back()->withErrors(['file' => 'An error occurred while uploading the file. Please try again.']);
        }
    }

}
