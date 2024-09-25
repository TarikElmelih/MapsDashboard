<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_type',
        'file_path',
        'status',
        'comment',
    ];

    // Add this constant to define allowed file types
    const ALLOWED_FILE_TYPES = [
        'CV',
        'Cover Letter',
        'Career Plan',
        'LinkedIn',
        'E-Mail Writing',
        'Presentation',
        'Portfolio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
