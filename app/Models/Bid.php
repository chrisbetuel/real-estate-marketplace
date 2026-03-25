<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $table = 'bids';

    protected $fillable = [
        'project_job_id',  // This matches your database column
        'professional_id',
        'amount',           // This matches your database column
        'estimated_days',   // This matches your database column
        'proposal',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'estimated_days' => 'integer',
    ];

    // Relationship with job (using project_job_id)
    public function job()
    {
        return $this->belongsTo(Job::class, 'project_job_id');
    }

    // Relationship with professional
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    // Alias for compatibility
    public function getBidAmountAttribute()
    {
        return $this->amount;
    }
}