<?php

namespace App\Http\Controllers\API;

use App\Page;
use App\Filters\PageFilters;
use App\Http\Requests\PageRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageApiRequest;

class PageController extends Controller
{
    public function index(PageApiRequest $request, PageFilters $filters)
    {
        $pages = Page::filter($filters);

        return response([
            'draw'				=> $request->draw,
            'data'				=> $pages->get(),
            'recordsTotal'		=> Page::count(),
            'recordsFiltered'	=> $filters->getFilteredCount(),
        ], 200);
    }

    public function store(PageRequest $request)
    {
		$request->merge([
			'published' => !! $request->published
		]);

        Page::create($request->only('en', 'de', 'published', 'slug'));

        return response([
            'message' => trans('messages.page_created')
        ], 200);
    }

    public function update(PageRequest $request, Page $page)
    {
		$request->merge([
			'published' => !! $request->published
		]);

        $page->update($request->only('en', 'de', 'published', 'slug'));

        return response([
            'message' => trans('messages.page_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Page::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.pages_deleted', $number, ['number' => $number])
        ], 200);
    }
}