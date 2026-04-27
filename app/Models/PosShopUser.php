<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosShopUser extends Model
{
    protected $table = 'pos_shop_user';

    protected $fillable = [
        'pos_shop_id',
        'user_id',
        'role',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(PosShop::class, 'pos_shop_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

