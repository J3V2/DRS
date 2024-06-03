<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLogout
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;
    public $userId;
    public $timestamp;
    public $officeId;

    /**
     * Create a new event instance.
     */
    public function __construct( $userId, $timestamp, $officeId)
    {
        $this->userId = $userId;
        $this->timestamp = $timestamp;
        $this->officeId = $officeId;
    }
}
