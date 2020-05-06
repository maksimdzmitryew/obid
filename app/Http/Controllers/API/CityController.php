<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Filters\CityFilters;
use App\Http\Requests\CityRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\CityApiRequest;

class CityController extends Controller
{
    public function index(CityApiRequest $request, CityFilters $filters)
    {
        $cities = City::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $cities->get(),
            'recordsTotal'    => City::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(CityRequest $request)
    {
        City::create($request->only('timezone', 'en', 'de'));

        return response([
            'message' => trans('messages.city_created')
        ], 200);
    }

    public function update(CityRequest $request, City $city)
    {
        $city->update($request->only('timezone', 'en', 'de'));

        return response([
            'message' => trans('messages.city_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        City::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.cities_deleted', $number, ['number' => $number])
        ], 200);
    }
}
