<?php

namespace Modules\Page\Guest;

#use                                          Auth;
use                     App\Http\Controllers\ControllerGuest as Controller;
use                       Modules\Page\Guest\Page;
use                          Illuminate\Http\Request;


class PageController extends Controller
{
	public function __construct()
	{
		$this->setEnv();
		$a_items	= $this->_env->s_model::select('id', 'slug')->wherePublished(TRUE)->get()->sortBy('id')->pluck('title', 'slug')->toArray();
		\View::composer($this->_env->s_theme . '::' . $this->_env->s_utype . '.*', function ($view) use ($a_items) {
			$view->with([
				$this->_env->s_plr => $a_items,
			]);
		});
	}

	/**
	 *	this is override to App\Http\Controllers\ControllerGuest::index
	 *	which is used by "ordinary" Welcome route
	 */
	public function index(Request $request) #: \Illuminate\View\View
	{
		$this->setEnv();

		$o_page		= Page::getItem($request, $this->_env, 'home');

		return view('welcome::guest.index', [
#		return view($this->_env->s_view . 'index', [
        		'page'              => $o_page,
				'attachments'		=> $o_page->atts,
		]);
	}

	public function posibnyk(Request $request){

		$this->setEnv();
#		$o_pages					= Page::select('id', 'slug')->wherePublished(TRUE)->get();

		$o_page		= Page::getItem($request, $this->_env, $request->page_slug, TRUE);

		return view(
			$this->_env->s_theme . '::' . $this->_env->s_utype . '.posibnyk',
			[
				'page_slug'			=> $request->page_slug,
				$this->_env->s_sgl	=> $o_page,
				'attachments'		=> $o_page->atts,
			]
		);
	}

/*
	public function showStaticPage1(Request $request){
		$o_page = Page::where('slug', $request->page_slug)->where('published', 1)->firstOrFail();

		return view(
			'public.pages.impressum',
			[
				'page'              => $o_page,
			]
		);

	}

	public function showStaticPage2(Request $request){
		if (! in_array($request->page_slug, ['about-us', 'confidentiality']))
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
*/

}
