<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->notification_id);
        $notification->read_at = now();
        $notification->save();

        return response()->json(['success' => true]);
    }
}

