<?php

namespace App\Http\Controllers\Admin;

use App\Slider;
use App\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FestivalController extends Controller
{
    public function index()
    {
        return view('admin.festivals.list', [
            'dates' => Festival::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'int'
        ]);

        return view('admin.festivals.form', [
            'sliders' => Slider::all(),
            'festival' => Festival::findOrNew($request->id)->load(['image']),
        ]);
    }
}
