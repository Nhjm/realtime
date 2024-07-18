<?php

namespace App\Events;

use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatGroup implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $groupChat;
    public $user_send;
    public $message;
    public function __construct(User $user_send, GroupChat $groupChat, $message)
    {
        $this->user_send = $user_send;
        $this->groupChat = $groupChat;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *

     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat_group.' . $this->groupChat->id);
    }
}
