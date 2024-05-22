<?php

namespace App\Listeners;

use App\Events\DocumentReleased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Notification;

class DocumentReleasedListener
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
    public function handle(DocumentReleased $event)
    {
            // Trigger notification
            Notification::create([
                'user_id' => $event->userId,
                'document_id' => $event->document->id,
                'user_triggered_id' => $event->userId,
                'type' => 'Document Released',
                'action' => $event->document->action,
                'triggered_at' => $event->timestamp,
                'data' => json_encode([
                    'title' => $event->document->title,
                    'tracking_number' => $event->document->tracking_number,
                    'designated_office' => $event->officeId,
                ]),
            ]);
    }

}
