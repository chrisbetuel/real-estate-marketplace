<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosExpense extends Model
{
    protected $table = 'pos_expenses';

    protected $fillable = [
        'user_id',
        'pos_shop_id',
        'expense_number',
        'category',
        'description',
        'amount',
        'expense_date',
        'payment_method',
        'receipt_number',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posShop(): BelongsTo
    {
        return $this->belongsTo(PosShop::class, 'pos_shop_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($expense) {
            if (empty($expense->expense_number)) {
                $expense->expense_number = 'EXP-' . strtoupper(uniqid());
            }
        });
    }
}

