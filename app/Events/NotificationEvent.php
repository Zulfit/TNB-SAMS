<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $body;
    public $timestamp;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
        $this->timestamp = now()->diffForHumans();
    }

    public function broadcastOn()
    {
        return new Channel('notification-channel');
    }

    public function broadcastAs()
    {
        return 'notification-event';
    }
}
