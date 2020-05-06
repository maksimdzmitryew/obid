<?php

namespace App\Http\Controllers\API;

use App\Profession;
use App\Filters\ProfessionFilters;
use App\Http\Requests\ProfessionRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionApiRequest;

class ProfessionController extends Controller
{
    public function index(ProfessionApiRequest $request, ProfessionFilters $filters)
    {
        $professions = Profession::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $professions->get(),
            'recordsTotal'    => Profession::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(ProfessionRequest $request)
    {
        Profession::create($request->only('en', 'de'));

        return response([
            'message' => trans('messages.professions_created')
        ], 200);
    }

    public function update(ProfessionRequest $request, Profession $profession)
    {
        $profession->update($request->only('en', 'de'));

        return response([
            'message' => trans('messages.professions_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Profession::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.professions_deleted', $number, ['number' => $number])
        ], 200);
    }
}
