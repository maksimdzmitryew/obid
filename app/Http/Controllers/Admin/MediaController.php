<?php

namespace App\Http\Controllers\Admin;

use App\Media;
use App\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function index()
    {
        return view('admin.media.list', [
            'dates'             => Media::getTimestampDates(),
            'festivals'         => Festival::all()->sortByDesc('year'),
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);
        
        return view('admin.media.form', [
            'festivals'         => Festival::all()->sortByDesc('year'),
            'media'             => Media::with(['festival'])->findOrNew($request->id),
        ]);
    }
}
