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
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_active' => 'boolean',
        'featured_until' => 'datetime',
        'price_sale' => 'decimal:2',
        'price_rent' => 'decimal:2',
    ];

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
        return $this->morphMany(Review::class, 'reviewable');
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
}