<?php

namespace App\Http\Controllers;

use App\Models\User;
use GetStream\StreamChat\Client;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatWithUser($userId)
    {
        // dd($userId);
        $targetUser = User::findOrFail($userId);

        $user = Auth::user();
        $client = new Client(
            config('services.stream.key'),
            config('services.stream.secret')
        );
        $token = $client->createToken($user->id);

        return view('chat', [
            'streamToken' => $token,
        ], compact('targetUser'));
    }
}
