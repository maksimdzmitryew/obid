<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Artist;
use App\Gallery;
use App\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BookController extends Controller
{
    public function index()
    {
        return view('admin.books.list', [

            'festivals'         => Festival::all()->sortByDesc('year'),
            'dates'             => Book::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.books.form', [
            'authors'           => Artist::all(),
            'galleries'         => Gallery::all(),
            'festivals'         => Festival::all()->sortByDesc('year'),

            'book'              => Book::findOrNew($request->id),
        ]);
    }
}
