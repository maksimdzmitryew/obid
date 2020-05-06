<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Event;
use App\Gallery;
use App\Festival;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        return view('admin.news.list', [
            'dates'             => Post::getTimestampDates(),
            'festivals'         => Festival::all()->sortByDesc('year'),
            'categories'        => Category::type('news')->get(),
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);
        
        return view('admin.news.form', [
            'events'            => Event::all(),
            'galleries'         => Gallery::all(),
            'festivals'         => Festival::all()->sortByDesc('year'),
            'categories'        => Category::type('news')->get(),
            'news'              => Post::with(['event', 'category'])->findOrNew($request->id),
        ]);
    }
}
