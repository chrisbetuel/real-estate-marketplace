<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profession',
        'years_experience',
        'hourly_rate',
        'bio',
        'skills',
        'stage',
        'subcategory',
        'certifications'
    ];

    protected $casts = [
        'years_experience' => 'integer',
        'hourly_rate' => 'decimal:2',
        'skills' => 'array',
        'certifications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
