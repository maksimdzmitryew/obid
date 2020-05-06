<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Filters\BookFilters;
use App\Http\Requests\BookRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookApiRequest;

class BookController extends Controller
{
    public function index(BookApiRequest $request, BookFilters $filters)
    {
        $books = Book::filter($filters);

        return response([
            'draw'              => $request->draw,
            'data'              => $books->with(['festival'])->get(),
            'recordsTotal'      => Book::count(),
            'qty_filtered'      => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(BookRequest $request)
    {
        $book = Book::create($request->only('url', 'api_code', 'festival_id', 'gallery_id', 'en', 'de'));
        $book->authors()->sync($request->author_ids);
        $book->processImages($request, 'image');
        #$book->attachImage($request);

        return response([
            'message' => trans('messages.book_created')
        ], 200);
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->only('url', 'api_code', 'festival_id', 'gallery_id', 'en', 'de'));
        $book->authors()->sync($request->author_ids);
        $book->processImages($request, 'image');
        #$book->updateImage($request);

        return response([
            'message' => trans('messages.book_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Book::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans('common/messages.books_deleted', $number, ['number' => $number])
        ], 200);
    }
}