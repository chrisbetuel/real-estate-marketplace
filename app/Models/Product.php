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
        'type', // 'sale' or 'rent'
        'category',
        'price_sale',
        'price_rent',
        'rent_period', // 'day', 'week', 'month', 'year'
        'quantity',
        'condition', // 'new', 'like_new', 'good', 'fair'
        'specifications', // JSON field for product specs
        'store_id',
        'is_active',
        'views_count',
        'featured_until',
        'images',
    ];

    protected $casts = [
        'specifications' => 'array',
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
     * Get the store that owns the product
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the reviews for the product
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get the total reviews count
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Check if product is featured
     */
    public function getIsFeaturedAttribute()
    {
        return $this->featured_until && $this->featured_until->isFuture();
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->maxNumberOfFiles(10);

        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(600)
            ->sharpen(10);
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

    /**
     * Accessor for unified price display
     */
    public function getPriceAttribute()
    {
        return $this->price_sale ?? $this->price_rent ?? $this->price ?? 0;
    }

    /**
     * Accessor for backward-compatible images (MediaLibrary + legacy JSON)
     */
    public function getImagesAttribute()
    {
        try {
            // Try MediaLibrary first (only if table exists)
            $media = $this->getMedia('product_images');
            if ($media->isNotEmpty()) {
                return $media->map(function ($item) {
                    return [
                        'url' => $item->getUrl('thumb'),
                        'original' => $item->getUrl()
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            // MediaLibrary table missing - skip silently
        }

        // Fallback to legacy JSON field
        $legacy = $this->attributes['images'] ?? null;
        return $legacy ? json_decode($legacy, true) : [];
    }

    /**
     * Get first image URL for quick display
     */
    public function getFirstImageAttribute()
    {
        $images = $this->images;
        return is_array($images) && count($images) > 0 
            ? (is_string($images[0]) ? asset('storage/' . $images[0]) : ($images[0]['url'] ?? asset('images/no-image.png')))
            : asset('images/no-image.png');
    }
}
