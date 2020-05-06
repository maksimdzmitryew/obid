<?php

namespace App\Http\Controllers\Admin;

use App\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.galleries.list', [
            'dates' => Gallery::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {

        $this->validate($request, [
            'id' => 'int'
        ]);
        
        return view('admin.galleries.form', [
            'gallery' => Gallery::with('images')->findOrNew($request->id),
        ]);
    }
}
