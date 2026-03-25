<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function professionalProfile()
    {
        return $this->hasOne(ProfessionalProfile::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'address',
        'profile_image',
        'is_verified',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the profile image URL
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        
        // Return a default avatar with user's initials
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?background=C9A53B&color=0F172A&size=100&name={$name}";
    }
    
    /**
     * Check if user is a client
     */
    public function isClient()
    {
        return $this->user_type === 'client';
    }
    
    /**
     * Check if user is a professional
     */
    public function isProfessional()
    {
        return $this->user_type === 'professional';
    }
}