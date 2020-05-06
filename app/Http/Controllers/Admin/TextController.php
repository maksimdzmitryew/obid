<?php

namespace App\Http\Controllers\Admin;

use App\Text;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TextController extends Controller
{
    public function index()
    {
        return view('admin.texts.list', [
            'dates' => Text::getTimestampDates()   
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.texts.form', [
            'text' => Text::findOrNew($request->id),
        ]);
    }
}
