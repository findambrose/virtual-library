<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->paginate(10);
        return response()->json($books, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'isbn' => 'required|unique:books,isbn',
            'author_id' => 'required'
        ]);

        try {
            Book::create($request->all());
            //order in reverse order
            $books = Book::with('author')->
            orderBy('id', 'desc')->
            paginate(10);
            return response()->json(['message' => "Book Created",
                'books' => $books], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Book creation failed!'], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::where('id', $id)->with('author')->first();
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book, 201);
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
}
