<?php

namespace App\Listeners;

use App\Events\UserLogout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class UserLogoutListener
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
    public function handle(UserLogout $event): void
    {
        Notification::create([
            'user_id' => $event->userId,
            'user_triggered_id' => $event->userId,
            'triggered_at' => $event->timestamp,
            'data' => json_encode([
                'office' => $event->officeId,
                'event_type' => 'Logout Successfully!!!',
            ]),
        ]);
    }
}
