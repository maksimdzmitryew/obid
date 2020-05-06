<?php

namespace App\Http\Controllers\Admin;

use App\Partner;
use App\Category;
use App\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.partners.list', [
            'categories'        => Category::type('partners')->get(),
            'festivals'         => Festival::all()->sortByDesc('year'),
            'dates'             => Partner::getTimestampDates()   
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        $partner = Partner::findOrNew($request->id)->load('image');
        
        return view('admin.partners.form', [
            'categories'        => Category::type('partners')->get(),
            'partner'           => $partner,
            'partner_festivals' => $partner->festivals(),
            'festivals'         => Festival::all()
        ]);
    }
}
