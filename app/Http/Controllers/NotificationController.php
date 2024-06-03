<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notificationIds = $request->input('notification_ids', []);

        Notification::whereIn('id', $notificationIds)
            ->where('user_id', auth()->id())
            ->update(['read_at' => now()]);

        return back()->with('messege', "All Notifications marked as read.");
    }

    public function markRead(Request $request)
    {
        $notificationIds = $request->input('notification_ids', []);

        Notification::whereIn('id', $notificationIds)
            ->where('user_id', auth()->id())
            ->update(['read_at' => now()]);

        return back()->with('messege', "Notifications marked as read.");
    }
}

