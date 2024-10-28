<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Profile;
use Illuminate\Http\Request;
use Pusher\Pusher;

class RFIDController extends Controller
{
    //
    public function receiveRFID(Request $request)
    {

        $request->validate([
            'card_uid' => 'required|string',
        ]);

        $cardUID = $request->query('card_uid');

        $user = Profile::where('rfid', $cardUID)->first();

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
                'user' => $user,
                // 'rfid' => $user->rfid,
            ]);

            return response()->json([
                'status' => 'User Found!',
                'user' => $user,
            ], 200);
            // return view('borrow', compact('user'));
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

    public function borrow(Request $request)
    {
        try {

            $data = $request->validate([
                'profile_id' => 'required',
            ]);

            if ($data) {
                Borrower::create($data);

                return response()->json([
                    'status' => 200,
                    'message' => 'borrow successfully!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
