<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    public function index()
    {
        return view('admin.places.list', [
            'dates'     => Place::getTimestampDates(),
            'cities'    => City::all()->sortBy('name'),
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.places.form', [
            'place'     => Place::findOrNew($request->id),
            'cities'    => City::all()->sortBy('name'),
        ]);
    }
}
