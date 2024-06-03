<?php

namespace App\Listeners;

use App\Events\DocumentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Notification;

class DocumentCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentCreated $event)
    {
            // Trigger notification
            Notification::create([
                'user_id' => $event->userId,
                'document_id' => $event->document->id,
                'user_triggered_id' => $event->userId,
                'type' => $event->document->type,
                'action' => $event->document->action,
                'triggered_at' => $event->timestamp,
                'data' => json_encode([
                    'title' => $event->document->title,
                    'tracking_number' => $event->document->tracking_number,
                    'office' => $event->officeId,
                    'event_type' => 'Created Document',
                ]),
            ]);
    }
}
