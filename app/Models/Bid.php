<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $table = 'bids';

    protected $fillable = [
        'project_job_id',
        'professional_id',
        'amount',
        'estimated_days',
        'proposal',
        'status',
        'transaction_id',
        'escrow_id',
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

    // Alias for controller compatibility
    public function bidder()
    {
        return $this->professional();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function escrowHold()
    {
        return $this->belongsTo(EscrowHold::class, 'escrow_id');
    }

    // Alias for compatibility
    public function getBidAmountAttribute()
    {
        return $this->amount;
    }
}
