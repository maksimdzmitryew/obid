<?php

namespace App\Http\Controllers\API;


use App\Place;
use App\Filters\PlaceFilters;
use App\Http\Requests\PlaceRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceApiRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PlaceController extends Controller
{
    public function index(PlaceApiRequest $request, PlaceFilters $filters)
    {
        $places = Place::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $places->get(),
            'recordsTotal'    => Place::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(PlaceRequest $request)
    {
        Place::create($request->only('city_id', 'en', 'de'));

        return response([], 200);
    }

    public function update(PlaceRequest $request, Place $place)
    {
        $place->update($request->only('city_id', 'en', 'de'));

        return response([], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Place::destroy($request->ids);

        return response([], 200);
    }
}
