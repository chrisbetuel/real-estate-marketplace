<?php

namespace App\Models;

class OrderStatus
{
    const PENDING = 'pending';
    const ESCROW_HELD = 'escrow_held';
    const SHIPPED = 'shipped';
    const DELIVERED = 'delivered';
    const BUYER_CONFIRMED = 'buyer_confirmed';
    const RELEASED = 'released';
    const DISPUTED = 'disputed';
    const CANCELLED = 'cancelled';
    
    public static function badges()
    {
        return [
            self::PENDING => 'bg-warning',
            self::ESCROW_HELD => 'bg-info',
            self::SHIPPED => 'bg-primary',
            self::DELIVERED => 'bg-success',
            self::RELEASED => 'bg-success',
            self::DISPUTED => 'bg-danger',
            self::CANCELLED => 'bg-secondary',
        ];
    }
    
    public static function labels()
    {
        return [
            self::PENDING => 'Pending Payment',
            self::ESCROW_HELD => 'Funds Held in Escrow',
            self::SHIPPED => 'Shipped',
            self::DELIVERED => 'Delivered',
            self::BUYER_CONFIRMED => 'Buyer Confirmed Receipt',
            self::RELEASED => 'Payment Released to Seller',
            self::DISPUTED => 'Disputed',
            self::CANCELLED => 'Cancelled',
        ];
    }
}

