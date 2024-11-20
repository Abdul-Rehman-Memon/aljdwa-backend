<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use function Illuminate\Log\log;


class GotNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // public $notification;
    /**
     * Create a new event instance.
     */
    public function __construct(public User $receiver, public $notification)
    {
        //
        \Log::info("GotNotification event instantiated for receiver ID: ");
        // $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {

        return [
            new Channel("notify.{$this->receiver->id}"),
        ];
        
    }


    public function broadcastWith()
    {
        \Log::info('Broadcasting message',$this->notification );
        return $this->notification;
    }
}
