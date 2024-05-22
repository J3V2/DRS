<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentReleased implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;
    public $userId;
    public $timestamp;
    public $officeIds;

    /**
     * Create a new event instance.
     */
    public function __construct($document, $userId, $timestamp, $officeIds)
    {
        $this->document = $document;
        $this->userId = $userId;
        $this->timestamp = $timestamp;
        $this->officeIds = $officeIds;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return array_map(function ($officeId) {
            return new PrivateChannel('office.' . $officeId);
        }, $this->officeIds);
    }
}
