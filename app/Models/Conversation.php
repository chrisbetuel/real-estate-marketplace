<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'status',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id')->orderBy('created_at', 'asc');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id')->latest();
    }

    public function unreadCountForUser($userId)
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        $lastReadAt = $participant ? $participant->pivot->last_read_at : null;
        
        $query = $this->messages()->where('user_id', '!=', $userId);
        
        if ($lastReadAt) {
            $query->where('created_at', '>', $lastReadAt);
        }
        
        return $query->count();
    }
    
    public function markAsRead($userId)
    {
        $this->participants()
            ->updateExistingPivot($userId, ['last_read_at' => now()]);
    }
}