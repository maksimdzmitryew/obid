<?php

namespace App\Http\Controllers\Admin;

use App\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfessionController extends Controller
{
    public function index()
    {
        return view('admin.professions.list', [
            'dates' => Profession::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.professions.form', [
            'profession' 	=> Profession::findOrNew($request->id),
        ]);
    }
}
