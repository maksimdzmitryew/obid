<?php

namespace App\Http\Controllers\Admin;

use App\Vocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VocationController extends Controller
{
    public function index()
    {
        return view('admin.vocations.list', [
            'dates' => Vocation::getTimestampDates()   
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.vocations.form', [
            'vocation' => Vocation::findOrNew($request->id),
        ]);
    }
}
