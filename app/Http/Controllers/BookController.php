<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Books/Index', [
            'books' => Book::with('author')->paginate(10),
            'authors' => Author::get()
        ]);
    }
}
