<?php

namespace App\Listeners;

use App\Events\DocumentTaggedAsTerminal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Notification;

class DocumentTaggedAsTerminalListener
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
    public function handle(DocumentTaggedAsTerminal $event): void
    {
        // Check if the action was triggered by a user within the same office or by the user themselves
        if ($this->isNotificationRequired($event->userId, $event->document->office_id, $event)) {
            // Trigger notification
            Notification::create([
                'user_id' => $event->document->user_id,
                'document_id' => $event->document->id,
                'user_triggered_id' => $event->userId,
                'type' => 'Document Tagged as Terminal',
                'action' => 'terminal',
                'triggered_at' => now(),
                'data' => ['document_name' => $event->document->name],
            ]);
        }
    }

    /**
     * Check if notification is required based on user and office.
     */
    private function isNotificationRequired($userId, $officeId, $event): bool
    {
        // Check if the user is the owner of the document
        if ($userId === $event->document->user_id) {
            return true;
        }

        // Check if the user is within the same office as the document's office
        // You may need to adjust this based on your application's structure
        $user = User::find($userId); // Assuming you have a User model
        if ($user && $user->office_id === $officeId) {
            return true;
        }

        return false;
    }
}
