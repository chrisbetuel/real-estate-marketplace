<?php
// app/Models/ProfessionalProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'profession', 'bio', 'years_experience',
        'qualifications', 'certifications', 'languages',
        'hourly_rate', 'availability', 'location_coordinates'
    ];

    protected $casts = [
        'qualifications' => 'array',
        'certifications' => 'array',
        'languages' => 'array',
        'location_coordinates' => 'array',
        'availability' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->user->reviewsReceived()->avg('rating') ?? 0;
    }

    public function getCompletedJobsCountAttribute()
    {
        return Job::where('assigned_professional_id', $this->user_id)
                  ->where('status', 'completed')
                  ->count();
    }
}