<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.list', [
            'dates' => Category::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.categories.form', [
            'category'    => Category::findOrNew($request->id),
            'types'       => Category::select('type')->distinct()->get()->map->type->toArray(),
// TODO keep for backward compatibility just in case
#            'types'       => Category::TYPES,
        ]);
    }
}
