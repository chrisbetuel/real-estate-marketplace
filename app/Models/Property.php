<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'address',
        'city',
        'state',
        'zip_code',
        'bedrooms',
        'bathrooms',
        'square_feet',
        'property_type',
        'status',
        'user_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'square_feet' => 'integer'
    ];

    // Relationship with user (owner/agent)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with conversations
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'job_id'); // Note: job_id in conversations table references properties
    }
}