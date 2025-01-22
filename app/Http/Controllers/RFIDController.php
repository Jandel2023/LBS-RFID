<?php

namespace App\Http\Controllers;

use App\Models\BorrowedBook;
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

        // $user = Profile::where('rfid', $cardUID)->with('borrowers.borrowed_books.book.author', 'borrowers.borrowed_books.book.category')->first();

        $user = Profile::where('rfid', $cardUID)->with('borrowers')->first();

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

            $payload = [
                'message' => 'RFID detected!',
                'status' => 200,
                'user' => $user,
                'borrower' => $user->borrowers->first(),
            ];

            $pusher->trigger('RFID-channel', 'RFID-channel', $payload);

            return response()->json([
                'status' => 'User Found!',
                'name' => $user->last_name.", ".$user->first_name,
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

            $pusher->trigger('RFID-channel', 'RFID-channel', [
                'status' => 404,
                'rfid' => $cardUID,
                'message' => 'RFID not recognized in the system!',

            ]);

            return response()->json([
                'status' => 'User Not Found!',
                'rfid'   => $cardUID,
                'message' => 'No user associated with this RFID',
            ], 404);
        }
    }

    public function listOfBooks($profile_id)
    {

        // dd($profile_id);
        $borrowedBooks = Borrower::where('profile_id', $profile_id)->with('borrowed_books.book.author', 'borrowed_books.book.category')->first();

        // dd($borrowedBooks);
        return response()->json([
            'status' => 200,
            'borrowed' => $borrowedBooks,
        ]);

    }

    public function borrow(Request $request)
    {
        try {

            $data = $request->validate([
                'borrower_id' => 'required',
                'book_id' => 'required',
            ]);

            // dd($data);

            $borrow = BorrowedBook::create($data);

            $user = $borrow->with('borrower.profile');
            $user = $borrow->borrower->profile;

            // dd($user->borrowers->first());
            if ($borrow) {
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    [
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'useTLS' => true,
                    ]
                );

                $payload = [
                    'message' => 'RFID detected!',
                    'status' => 200,
                    'user' => $user,
                    'borrower' => $user->borrowers->first(),
                ];

                $pusher->trigger('RFID-channel', 'RFID-channel', $payload);

                return response()->json([
                    'message' => 'borrowed',
                ]);
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

                $pusher->trigger('RFID-channel', 'RFID-channel', [
                    'status' => 404,
                    // 'rfid' => $cardUID,
                    'message' => 'RFID not recognized in the system!',

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
