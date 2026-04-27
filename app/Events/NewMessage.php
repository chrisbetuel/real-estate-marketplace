<?php
// app/Events/NewMessage.php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,\n            'sender_id' => $this->message->user_id,\n            'sender_name' => $this->message->user->name,\n            'conversation_id' => $this->message->conversation_id,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'attachments' => $this->message->attachments
        ];
    }
}