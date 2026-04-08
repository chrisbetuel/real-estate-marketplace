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
        return $this->hasOne(Store::class, 'owner_id');
    }

    /**
     * Get conversations where user is a participant
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
                    ->withTimestamps()
                    ->latest('updated_at');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function getRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 4.8;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
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

    /**
     * Get masked email for unpaid connections
     */
    public function getMaskedEmailAttribute()
    {
        [$local, $domain] = explode('@', $this->email, 2);
        return substr($local, 0, 3) . '***@' . $domain;
    }

    /**
     * Get masked phone for unpaid connections
     */
    public function getMaskedPhoneAttribute()
    {
        if (!$this->phone) return null;
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        return substr($phone, 0, 3) . '***' . substr($phone, -4);
    }
}

