<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Press;
use App\Gallery;
use App\Festival;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PressController extends Controller
{
    public function index()
    {
        return view('admin.presses.list', [
            'dates'             => Press::getTimestampDates(),
            'festivals'         => Festival::all()->sortByDesc('year'),
            'cities'            => City::all()->sortBy('name'),
            'categories'        => Category::type('events')->get(),
            'types'             => Category::type('presses')->get(),
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.presses.form', [
            'press'             => Press::findOrNew($request->id),
            'festivals'         => Festival::all()->sortByDesc('year'),
            'galleries'         => Gallery::all(),
            'cities'            => City::all()->sortBy('name'),
            'categories'        => Category::type('events')->get(),
            'types'             => Category::type('presses')->get(),
// TODO keep for backward compatibility just in case
#            'types'       => Press::TYPES,
        ]);
    }
}
