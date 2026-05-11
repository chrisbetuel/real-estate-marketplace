<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'type',
        'category',
        'price_sale',
        'price_rent',
        'rent_period',
        'quantity',
        'condition',
        'specifications',
        'store_id',
        'is_active',
        'views_count',
        'featured_until',
        'images',
    ];

    protected $casts = [
        'specifications' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'featured_until' => 'datetime',
        'price_sale' => 'decimal:2',
        'price_rent' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Scope for available products (active + in stock)
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
                     ->where('quantity', '>', 0);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for sale products
     */
    public function scopeForSale($query)
    {
        return $query->where('type', 'sale');
    }

    /**
     * Scope for rent products
     */
    public function scopeForRent($query)
    {
        return $query->where('type', 'rent');
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured_until', '>', now());
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getIsFeaturedAttribute()
    {
        return $this->featured_until && $this->featured_until->isFuture();
    }

public function getPriceAttribute()
    {
        return $this->price_sale ?? $this->price_rent ?? 0;
    }

    /**
     * Get stock attribute (alias for quantity)
     */
    public function getStockAttribute()
    {
        return $this->quantity;
    }

    /**
     * Get first image URL for quick display
     */
    public function getFirstImageAttribute()
    {
        // Try Spatie MediaLibrary first
        try {
            $media = $this->getFirstMedia('product_images');
            if ($media) {
                return $media->getUrl();
            }
        } catch (\Exception $e) {
            // MediaLibrary error - continue to fallback
        }

        // Fallback to legacy JSON field
        $legacy = $this->attributes['images'] ?? null;
        if ($legacy) {
            $images = json_decode($legacy, true);
            if (is_array($images) && count($images) > 0) {
                $firstImage = $images[0];
                $imagePath = is_string($firstImage) ? $firstImage : ($firstImage['url'] ?? null);

                if ($imagePath) {
                    // Check if it's a full URL (starts with http:// or https://)
                    if (preg_match('/^https?:\/\//', $imagePath)) {
                        return $imagePath;
                    } else {
                        return asset('storage/' . ltrim($imagePath, '/'));
                    }
                }
            }
        }

        return asset('images/no-image.png');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
            ->maxNumberOfFiles(10);
    }
}
