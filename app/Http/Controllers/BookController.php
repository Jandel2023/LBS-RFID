<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Profile;
use Illuminate\Http\Request;
use Pusher\Pusher;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::with('author', 'category')->simplePaginate(5);

        $bookTotal = Book::count();

        return view('layout_page.books.list', compact('books', 'bookTotal'))->with('i', (request()->input('pages', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $isbn)
    {
        //
        // dd($isbn);

        $book = Book::where('isbn', $isbn)->with('author', 'category')->first();

        // dd($book);
        if ($book) {
            return response()->json([
                'book' => $book,
            ]);
        }

        return response()->json([
            'message' => 'book not found!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //update book status
        $data = $request->validate([
            'book_id' => 'required',
            'borrower_id' => 'required',
        ]);

        $userBorrow = BorrowedBook::where('borrower_id', $data['borrower_id'])
            ->with('borrower.profile') // Eager load the 'profile' relationship
            ->first();

        $user = $userBorrow->borrower->profile;

        $borrowedBook = BorrowedBook::where('book_id', $data['book_id'])->update([
            'status' => false,
        ]);

        if ($borrowedBook) {
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
                'message' => 'returned',
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listBooks()
    {
        return view('index');
    }

    public function home()
    {
        return view('layout_page.dashboard_page');
    }
}
