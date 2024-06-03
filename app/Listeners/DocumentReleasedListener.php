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
        // Notify the designated offices
        foreach ($event->officeId as $officeId) {
            $officeUsers = User::where('office_id', $officeId)->get();
            foreach ($officeUsers as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'document_id' => $event->document->id,
                    'user_triggered_id' => $event->userId,
                    'type' => $event->document->type,
                    'action' => $event->document->action,
                    'triggered_at' => $event->timestamp,
                    'data' => json_encode([
                        'title' => $event->document->title,
                        'tracking_number' => $event->document->tracking_number,
                        'office' => $officeId,
                        'event_type' => 'Sent Document',
                    ]),
                ]);
            }
        }

        // Notify the user's office
        $userOfficeUsers = User::where('office_id', $event->userOffice)->get();
        foreach ($userOfficeUsers as $user) {
            Notification::create([
                'user_id' => $user->id,
                'document_id' => $event->document->id,
                'user_triggered_id' => $event->userId,
                'type' => $event->document->type,
                'action' => $event->document->action,
                'triggered_at' => $event->timestamp,
                'data' => json_encode([
                    'title' => $event->document->title,
                    'tracking_number' => $event->document->tracking_number,
                    'office' => $event->userOffice,
                    'event_type' => 'Released Document',
                ]),
            ]);
        }
    }
}
