<?php

namespace App\Http\Controllers\API;

use App\Festival;
use App\Filters\FestivalFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\FestivalRequest;
use App\Http\Requests\FestivalApiRequest;

class FestivalController extends Controller
{
    public function index(FestivalApiRequest $request, FestivalFilters $filters)
    {
        return response([
            'draw'            => $request->draw,
            'data'            => Festival::filter($filters)->get(),
            'recordsTotal'    => Festival::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(FestivalRequest $request)
    {
        $request->merge([
            'active' => !! $request->active,
            'published' => !! $request->published,
        ]);

        //Festival::whereIn('id', Festival::select('id')->get()->pluck('id'))->update(['active' => 0]);

        $festival = Festival::create($request->only('slider_id', 'active', 'published', 'year', 'en', 'de', 'color'))
            ->attachImage($request);

        if (!isset($request->en['file_id'])) {
            $festival->translate('en')->attachFile(null);
        } else {
            $festival->translate('en')->attachFile($request->en['file_id']);
        }

        if (!isset($request->de['file_id'])) {
            $festival->translate('de')->attachFile(null);
        } else {
            $festival->translate('de')->attachFile($request->de['file_id']);
        }

        return response([
            'message' => trans('messages.festival_created')
        ], 200);
    }

    public function update(FestivalRequest $request, Festival $festival)
    {
        $request->merge([
            'active' => !! $request->active,
            'published' => !! $request->published,
        ]);

        //Festival::whereIn('id', Festival::select('id')->get()->pluck('id'))->update(['active' => 0]);

        $festival->update($request->only('slider_id', 'active', 'published', 'year', 'en', 'de', 'color'));
        $festival->updateImage($request);

        if (!isset($request->en['file_id'])) {
            $festival->translate('en')->updateFile(null);
        } else {
            $festival->translate('en')->updateFile($request->en['file_id']);
        }

        if (!isset($request->de['file_id'])) {
            $festival->translate('de')->updateFile(null);
        } else {
            $festival->translate('de')->updateFile($request->de['file_id']);
        }

        return response([
            'message' => trans('messages.festival_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Festival::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.festivals_deleted', $number, ['number' => $number])
        ], 200);
    }
}
