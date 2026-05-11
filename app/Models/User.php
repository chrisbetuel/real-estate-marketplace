<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

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

    // Relationships
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

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

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

    public function posShops()
    {
        return $this->hasMany(PosShop::class, 'owner_id');
    }

    public function managedPosShops()
    {
        return $this->belongsToMany(PosShop::class, 'pos_shop_user')
                    ->withPivot('role', 'is_active')
                    ->withTimestamps();
    }

    // Accessors
    public function getRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 4.8;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Get the profile image URL
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image && Storage::disk('public')->exists($this->profile_image)) {
            return Storage::url($this->profile_image);
        }
        
        // Return default avatar with user's initials
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&bold=true&size=120&name={$name}";
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

    // Role check methods
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
     * Check if user is a store owner
     */
    public function isStoreOwner()
    {
        return $this->user_type === 'store_owner' || $this->store;
    }

    /**
     * Check if user is a driver
     */
    public function isDriver()
    {
        return $this->user_type === 'driver' || $this->driver;
    }

    /**
     * Check if user can access a specific POS shop
     */
    public function canAccessPosShop(PosShop $shop): bool
    {
        if ($shop->owner_id === $this->id) {
            return true;
        }

        return $this->managedPosShops()
            ->where('pos_shops.id', $shop->id)
            ->wherePivot('is_active', true)
            ->exists();
    }

    /**
     * Get user's role in a specific POS shop
     */
    public function posShopRole(PosShop $shop): ?string
    {
        if ($shop->owner_id === $this->id) {
            return 'admin';
        }

        $pivot = $this->managedPosShops()
            ->where('pos_shops.id', $shop->id)
            ->wherePivot('is_active', true)
            ->first();

        return $pivot?->pivot?->role;
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }
}

