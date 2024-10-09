<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\User;
use App\Events\RFIDDetected;
use Illuminate\Http\Request;

class RFIDController extends Controller
{
    //
    public function receiveRFID(Request $request)
    {

        $request->validate([
            'card_uid' => 'required|string',
        ]);

        $cardUID = $request->query('card_uid');

        $user = User::where('rfid', $cardUID)->first();

        if ($user) {
          $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('rfid-channel', 'rfid-channel', [
            'message' => 'RFID detected!',
            'status' => 200,
            'user' => $user->name,
            'rfid' => $user->rfid,
        ]);


            return response()->json([
                'status' => 'User Found!',
                'user' => $user->name,
            ], 200);
        } else {

          $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('rfid-channel', 'rfid-channel', [
            'status' => 404,
            'message' => 'RFID not recognized in the system!',

        ]);
            return response()->json([
                'status' => 'User Not Found!',
                'message' => 'No user associated with this RFID',
            ], 404);
        }
    }
}
