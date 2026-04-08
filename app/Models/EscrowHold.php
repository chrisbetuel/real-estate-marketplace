<?php
// app/Models/EscrowHold.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowHold extends Model
{
    protected $fillable = [
        'job_id', 'order_id', 'client_id', 'professional_id', 'store_id', 'amount', 
        'platform_fee', 'status', 'released_at', 'refunded_at',
        'release_conditions', 'dispute_reason'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'released_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function release()
    {
        $this->status = 'released';
        $this->released_at = now();
        $this->save();
        
        if ($this->order_id) {
            // Store order escrow
            $seller = $this->store->owner;
            $sellerWallet = $seller->wallet;
            $netAmount = $this->amount - $this->platform_fee;
            $sellerWallet->addBalance($netAmount, "Order #{$this->order->order_number} payment released");
            
            // Update order items stock and order status
            foreach ($this->order->items as $item) {
                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sales_count', $item->quantity);
            }
            $this->order->update(['status' => 'released']);
            
            // Platform commission (assume admin user_id = 1)
            $platformWallet = Wallet::where('user_id', 1)->first();
            if ($platformWallet) {
                $platformWallet->addBalance($this->platform_fee, "Commission from order #{$this->order->order_number}");
            }
            
            // Commission record
            \App\Models\CommissionRecord::create([
                'order_id' => $this->order_id,
                'store_id' => $this->store_id,
                'amount' => $this->amount,
                'commission_percentage' => 10,
                'commission_amount' => $this->platform_fee,
                'status' => 'paid'
            ]);
        } else if ($this->job_id) {
            // Existing job logic
            $professionalWallet = $this->professional->wallet;
            $professionalWallet->addBalance($this->amount, "Job payment: {$this->job->title}");
            
            $platformWallet = Wallet::where('user_id', 1)->first();
            $platformWallet->addBalance($this->platform_fee, "Commission: {$this->job->title}");
            
            \App\Models\CommissionRecord::create([
                'job_id' => $this->job_id,
                'professional_id' => $this->professional_id,
                'job_amount' => $this->amount,
                'commission_percentage' => 10,
                'commission_amount' => $this->platform_fee,
                'status' => 'paid'
            ]);
        }
        
        return true;
    }

    public function refund()
    {
        $this->status = 'refunded';
        $this->refunded_at = now();
        $this->save();
        
        $buyer = $this->order ? $this->order->user : $this->client;
        $buyerWallet = $buyer->wallet;
        $buyerWallet->addBalance($this->amount, "Escrow refund for " . ($this->order ? "order #{$this->order->order_number}" : "job #{$this->job->id}"));
        
        if ($this->order) {
            $this->order->update(['status' => 'cancelled']);
        }
        
        return true;
    }

    public static function createForOrder($order)
    {
        $platformFee = $order->total * 0.1;
        return self::create([
            'order_id' => $order->id,
            'store_id' => $order->store_id,
            'client_id' => $order->user_id,
            'amount' => $order->total,
            'platform_fee' => $platformFee,
            'status' => 'held',
            'held_until' => now()->addDays(30),
        ]);
    }
}