<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Slide;
use App\Filters\SlideFilters;
use App\Http\Requests\SlideRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SlideApiRequest;

class SlideController extends Controller
{
    public function index(SlideApiRequest $request, SlideFilters $filters)
    {
        $slides = Slide::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $slides->get(),
            'recordsTotal'    => Slide::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(SlideRequest $request)
    {
        Slide::create($request->only('slider_id', 'position', 'en', 'de'))->attachImage($request);

        return response([], 200);
    }

    public function update(SlideRequest $request, Slide $slide)
    {
        $slide->update($request->only('slider_id', 'position', 'en', 'de'));
        $slide->updateImage($request);

        return response([], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Slide::destroy($request->ids);

        return response([], 200);
    }
}
