<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_job_id', 'product_id', 'client_id', 'professional_id',
        'amount', 'platform_fee', 'professional_amount', 'status',
        'payment_method', 'transaction_reference', 'payment_details',
        'held_until', 'released_at'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'held_until' => 'datetime',
        'released_at' => 'datetime',
    ];

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