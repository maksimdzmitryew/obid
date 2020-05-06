<?php

namespace App\Http\Controllers\Admin;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.sliders.list', [
            'dates' => Slider::getTimestampDates()   
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.sliders.form', [
            'slider' => Slider::findOrNew($request->id),
        ]);
    }
}
