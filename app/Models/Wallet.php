<?php
// app/Models/Wallet.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id', 'balance', 'pending_balance', 'total_earned', 'total_spent'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'total_spent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addBalance($amount, $description = null)
    {
        $this->balance += $amount;
        $this->total_earned += $amount;
        $this->save();
        
        // Create transaction record
        Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'deposit',
            'amount' => $amount,
            'status' => 'completed',
            'description' => $description,
            'balance_after' => $this->balance,
        ]);
        
        return $this;
    }

    public function deductBalance($amount, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }
        
        $this->balance -= $amount;
        $this->total_spent += $amount;
        $this->save();
        
        Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'withdrawal',
            'amount' => $amount,
            'status' => 'completed',
            'description' => $description,
            'balance_after' => $this->balance,
        ]);
        
        return $this;
    }
}