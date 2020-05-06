<?php

namespace App\Http\Controllers\Frontend;

use App\Press;
use App\Festival;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PressController extends Controller
{
    public function index(Request $request)
    {
        $festival = Festival::current();

        return view('public.press.list', [
            'presses' => $festival->presses()->get(),
            'press_categories' => Category::type('presses')->get(),
        ]);
    }

    public function gallery(Request $request)
    {
        $press = Festival::current()->presses()->whereTranslation('slug', $request->gallery_slug)->firstOrFail();
        $gallery_parts = $press->gallery->images()->get()->split(4);

        return view('public.press.gallery', [
            'press' => $press,
            'gallery_parts' => $gallery_parts
        ]);
    }
}
