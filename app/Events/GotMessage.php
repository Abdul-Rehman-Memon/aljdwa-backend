<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use function Illuminate\Log\log;


class GotMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // public $message;
    /**
     * Create a new event instance.
     */
    public function __construct(public User $receiver, public User $sender, public string $message)
    {
        //
        // \Log::info("GotMessage event instantiated for receiver ID: ");
        // $this->message = $messag;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("chat"),
            // new PrivateChannel("chat.{$this->receiver->id}"),
        ];
    }

    // public function broadcastWith(){

    //     return $this->message;
    // }

    public function broadcastWith(): array
{
    \Log::info('Broadcasting message', [
        'receiver_id' => $this->receiver->id,
        'sender_id' => $this->sender->id,
        'message' => $this->message
    ]);
    
    return [
        'receiver_id' => $this->receiver->id,
        'sender_id' => $this->sender->id,
        'message' => $this->message
    ];
}
}
