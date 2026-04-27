<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'store_id',
        'driver_id',
        'delivery_type',
        'delivery_price',
        'delivery_status',
        'delivery_eta',
        'delivery_route',
        'subtotal',
        'tax',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
    ];

    public function escrowHold()
    {
        return $this->hasOne(EscrowHold::class, 'order_id');
    }

    protected $casts = [
        'shipping_address' => 'array',
        'delivery_route' => 'array',
        'delivery_eta' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute()
    {
        return \App\Models\OrderStatus::badges()[$this->status] ?? 'bg-secondary';
    }

    public function getStatusLabelAttribute()
    {
        return \App\Models\OrderStatus::labels()[$this->status] ?? ucfirst($this->status);
    }
}

