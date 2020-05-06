<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.list', [
            'dates' => Page::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.pages.form', [
            'page' 	=> Page::findOrNew($request->id),
        ]);
    }
}
