<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        // Core relations
        'user_id',
        'client_id',
        'professional_id',
        'project_job_id',
        'product_id',

        // Transaction details
        'type',
        'amount',
        'platform_fee',
        'professional_amount',
        'status',
        'payment_method',
        'transaction_reference',
        'reference_id',
        'description',

        // Balance tracking
        'balance_before',
        'balance_after',

        // Extra details
        'payment_details',
        'held_until',
        'released_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'payment_details' => 'array',
        'held_until' => 'datetime',
        'released_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function projectJob()
    {
        return $this->belongsTo(Job::class, 'project_job_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}