<?php

namespace App\Http\Controllers\Admin;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        return view('admin.cities.list', [
            'dates' => City::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.cities.form', [
            'city' 			=> City::findOrNew($request->id),
            'timezones' 	=> array_filter(timezone_identifiers_list(), function($timezone){
                return strpos($timezone, 'Europe') === 0;
            })
        ]);
    }
}
