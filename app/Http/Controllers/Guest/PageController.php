<?php

namespace App\Http\Controllers\Guest;

use App\Page;
#use Illuminate\Http\Request;
#use App\Http\Controllers\Controller;
use                          Illuminate\Http\Request;
use                     App\Http\Controllers\Controller as BaseController;

class PageController extends BaseController {

    protected $fillable = [];

	public static function getFillable()
	{
		return [];
	}
	public static function getFields()
	{
		return [];
	}

    public function showStaticPage(Request $request){
		if ($request->page_slug != 'about-us')
			die();
		$this->setEnv();
#        $o_page = Page::where('slug', $request->page_slug)->where('published', 1)->firstOrFail();
        return view(
#        	'public.pages.static',
        	'providnykV1::guest.static',
        	[
        		'page_slug'         => $request->page_slug,
#        		'page'              => $o_page,
        	]
    	);

    }

}
