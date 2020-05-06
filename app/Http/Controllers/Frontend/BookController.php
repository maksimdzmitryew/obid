<?php

namespace App\Http\Controllers\Frontend;

use App\Book;
use App\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $book = Festival::current()->book;

        return view('public.books.single', [
            'book' => $book,
            'books' => Book::where('id', '!=', $book->id)->get()
        ]);
    }
}
