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
     * Driver relationship
     */
    public function driver()
    {
        return $this->hasOne(Driver::class);
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
     -->
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
     * POS shops owned by this user
     */
    public function posShops()
    {
        return $this->hasMany(PosShop::class, 'owner_id');
    }

    /**
     * POS shops where this user is staff
     */
    public function managedPosShops()
    {
        return $this->belongsToMany(PosShop::class, 'pos_shop_user')
                    ->withPivot('role', 'is_active')
                    ->withTimestamps();
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

    /**
     * Check if user is a client
     -->
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

