<?php

namespace App\Http\Controllers\API;

use App\Media;
use App\Filters\MediaFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\MediaApiRequest;

class MediaController extends Controller
{
	public function index(MediaApiRequest $request, MediaFilters $filters)
	{
/*
		return response([
			'draw'				=> $request->draw,
			'data'				=> Media::filter($filters)->get(),
			'recordsTotal'		=> Media::count(),
			'qty_filtered'		=> $filters->getFilteredCount(),
		], 200);
*/

        $media = Media::filter($filters);

        // TODO
        // this is for compliance with ajax requests
        // that require 'file' variable in template
        $res = $media->get();
        for ($i = 0; $i < count($res); $i++)
        {
            $res[$i]['file']['url'] = $res[$i]->file->url;
        }
        return response([
            'draw'              => $request->draw,
            'data'              => $res,
            'recordsTotal'      => Media::count(),
            'qty_filtered'      => $filters->getFilteredCount(),
        ], 200);

    }

    public function store(MediaRequest $request)
    {
        $request->merge([
            'promoting' => !! $request->promoting,
            'published' => !! $request->published
        ]);

        Media::create($request->only('published_at','festival_id', 'promoting', 'published', 'en', 'de'))
            ->attachFile($request->file_id);

        return response([], 200);
    }

    public function update(MediaRequest $request, Media $media)
    {
        $request->merge([
            'promoting' => !! $request->promoting,
            'published' => !! $request->published
        ]);

        $media->update($request->only('published_at','festival_id', 'promoting', 'published', 'en', 'de'));
        $media->updateFile($request->file_id);

        return response([], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Media::destroy($request->ids);

        return response([], 200);
    }
}
