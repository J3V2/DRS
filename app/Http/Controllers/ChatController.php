<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{   

    public function Messages() {
        $users = User::all(); // Fetch all users with name and email
        return view('chats.messages',compact('users'));
    }

    public function sendMessage(Request $request)
    {
        $chat = new Chat;
        $chat->user_id = Auth::id();
        $chat->message = $request->message;
        $chat->save();

        return response()->json(['status' => 'success']);
    }

    public function getMessages()
    {   
        $chats = Chat::all();
        return view('chats.messages',compact('chats'));
    }

}
