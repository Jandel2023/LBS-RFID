<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
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

        $books = Book::with('author', 'category')->get();

        return view('index', compact('books'))->with('i', (request()->input('pages', 1) - 1) * 5);
    }
}
