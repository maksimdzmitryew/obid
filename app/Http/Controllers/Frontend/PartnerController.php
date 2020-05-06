<?php

namespace App\Http\Controllers\Frontend;

use App\Festival;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function index()
    {
        return view('public.partners.list', [
            'partner_categories' => Category::type('partners')->with(['partners' => function($query) {
                $query->where('festival_id', Festival::current()->id);
            }])->orderBy('title')->get()
        ]);
    }
}
