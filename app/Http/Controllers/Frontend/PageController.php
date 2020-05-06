<?php

namespace App\Http\Controllers\Frontend;

use App\Page;
use App\Media;
use App\Artist;
use App\Festival;
// use App\Setting;
use App\Traits\FestivalTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller{

    use FestivalTrait {

        FestivalTrait::__construct as protected __traitConstruct;

    }

    public function __construct(Request $request){

        $this->__traitConstruct($request);

    }

    public function aboutUs(Request $request){

        return view('public.pages.about-us', [
            'board_members' => Artist::boardMembers()->get(),
            'team_members' => Artist::teamMembers()->get(),
        ]);
    }

    public function showStaticPage(Request $request){
        $o_page = Page::where('slug', $request->page_slug)->where('published', 1)->firstOrFail();

        return view(
        	'public.pages.impressum',
        	[
        		'page'              => $o_page,
        	]
    	);

    }

}
