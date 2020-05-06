<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Artist;
use App\Gallery;
use App\Festival;
use App\EventHandling;
use App\Category;
use App\Vocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index()
    {
        return view('admin.events.list', [
            'categories'        => Category::type('events')->get(),
            'festivals'         => Festival::all()->sortByDesc('year'),
            'dates'             => Event::getTimestampDates()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);
		$o_res = Event::findOrNew($request->id);
		# for cleaner slug after opening duplicated event first time
		foreach($o_res->translations as $item => $values){
			if (stristr($values->slug, 'copied-from-event'))
				unset($values->slug);
		}
        return view('admin.events.form', [
            'artists'           => Artist::all(),
            'galleries'         => Gallery::all(),
            'event'             => $o_res,
            'festivals'         => Festival::all()->sortByDesc('year'),
            'categories'        => Category::type('events')->get(),
            'vocations'         => Vocation::all(),
        ]);
    }

    public function duplicate(Request $request)
    {
		$this->validate($request, [
			'id' => 'integer'
		]);
    	$i_res = Event::duplicate($request);
    	return redirect(route('admin.events.form', $i_res));
    }

}
