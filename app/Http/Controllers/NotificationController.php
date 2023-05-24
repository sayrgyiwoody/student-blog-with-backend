<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        
        $message = $request->input('message');
        // Code to send the notification...

        // Return a response
        return response()->json(['success' => true]);
    }
}
