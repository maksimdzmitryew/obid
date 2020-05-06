<?php

namespace App\Http\Controllers\Frontend;

use App\Post;
use App\Event;
use App\Festival;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function post(Request $request)
    {
        return view('public.news.single', [
            'post' => Festival::current()->news()->whereTranslation('slug', $request->slug)->first(),
            'news' => Festival::current()->news()->take(4)->get(),
            'events' => Event::promoting()->with('holdings')->get()
        ]);
    }

    public function news(Request $request)
    {
        return view('public.news.list', [
            'news' => Festival::current()->news()->paginate(10),
            'categories' => Category::type('news')->get(),
        ]);
    }
}
