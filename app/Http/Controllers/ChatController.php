<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GetStream\StreamChat\Client;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatWithStaff($staff_id)
    {
        $staff = User::findOrFail($staff_id); // or Staff::findOrFail($staff_id)
        $currentUser = Auth::user(); // make sure user is authenticated

        return view('chat', compact('staff', 'currentUser'));
    }
}
