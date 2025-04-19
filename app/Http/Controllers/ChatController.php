<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GetStream\StreamChat\Client;
use Illuminate\Support\Facades\Auth;
use GetStream\StreamChat\StreamChat;

class ChatController extends Controller
{
    public function chatWithUser($userId)
    {
        // dd($userId);
        $targetUser = User::findOrFail($userId);

        $user = Auth::user();
        $client = new Client(
            env('STREAM_API_KEY'),
            env('STREAM_API_SECRET')
        );        $token = $client->createToken($user->id);

        return view('chat', [
            'streamToken' => $token
        ], compact('targetUser'));
    }

}
