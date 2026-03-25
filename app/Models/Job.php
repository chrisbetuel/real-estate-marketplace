<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'project_jobs'; // or whatever your table name is

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'service_category',
        'budget_min',
        'budget_max',
        'deadline',
        'location',
        'required_skills',
        'status',
        'assigned_professional_id',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'deadline' => 'datetime',
        'required_skills' => 'array',
    ];

    // Relationship with client (user who posted the job)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relationship with assigned professional
    public function assignedProfessional()
    {
        return $this->belongsTo(User::class, 'assigned_professional_id');
    }

    // Relationship with bids
    public function bids()
    {
        return $this->hasMany(Bid::class, 'job_id');
    }

    // Alias for client relationship (for compatibility)
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}