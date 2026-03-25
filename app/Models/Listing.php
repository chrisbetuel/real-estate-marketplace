<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $table = 'listings';

    protected $fillable = [
        'title',
        'description',
        'category',
        'budget_min',
        'budget_max',
        'location',
        'status',
        'user_id',
        'deadline',
        'experience_level',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'deadline' => 'datetime',
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with bids - using listing_id
    public function bids()
    {
        return $this->hasMany(Bid::class, 'listing_id'); // Explicitly set foreign key
    }

    // Scope for open listings
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Get the accepted bid
    public function acceptedBid()
    {
        return $this->hasOne(Bid::class, 'listing_id')->where('status', 'accepted');
    }
}