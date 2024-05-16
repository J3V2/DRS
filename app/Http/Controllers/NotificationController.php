<?php

namespace App\Http\Controllers;
use App\Events\DocumentCreated;
use App\Events\DocumentReceived;
use App\Events\DocumentReleased;
use App\Events\DocumentTaggedAsTerminal;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function updateNotifications() {
        // Listen for events and update the notification dropdown
        DocumentCreated::dispatch();
        DocumentReceived::dispatch();
        DocumentReleased::dispatch();
        DocumentTaggedAsTerminal::dispatch();

        // Return a response or redirect as needed
        return response()->json(['message' => 'Notifications updated']);
    }
}
