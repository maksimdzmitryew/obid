<?php

namespace App\Http\Controllers\API;

use App\Vocation;
use App\Filters\VocationFilters;
use App\Http\Requests\VocationRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\VocationApiRequest;

class VocationController extends Controller
{
    public function index(VocationApiRequest $request, VocationFilters $filters)
    {
        $vocations = Vocation::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $vocations->get(),
            'recordsTotal'    => Vocation::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(VocationRequest $request)
    {
        Vocation::create($request->only('en', 'de'));

        return response([
            'message' => trans('messages.vocation_created')
        ], 200);
    }

    public function update(VocationRequest $request, Vocation $vocation)
    {
        $vocation->update($request->only('en', 'de'));

        return response([
            'message' => trans('messages.vocation_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Vocation::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.vocations_deleted', $number, ['number' => $number])
        ], 200);
    }
}
