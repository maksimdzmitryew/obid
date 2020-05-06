<?php

namespace App\Http\Controllers\API;

use App\Partner;
use App\Filters\PartnerFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\PartnerRequest;
use App\Http\Requests\PartnerApiRequest;


class PartnerController extends Controller
{
    public function index(PartnerApiRequest $request, PartnerFilters $filters)
    {
        return response([
            'draw' => $request->draw,
            'data' => Partner::filter($filters)->with(['festivals', 'image'])->get(),
            'recordsTotal' => Partner::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
            'post' => $request->post()
        ], 200);
    }

    public function store(PartnerRequest $request)
    {
        $request->merge([
            'promoting' => !! $request->promoting
        ]);

        $partner = Partner::create($request->only('title', 'url', 'promoting', 'category_id'));
        $partner->festivals()->sync($request->post('festivals'));
        $partner->processImages($request);
#        $partner->attachImage($request);

        return response([], 200);
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $request->merge([
            'promoting' => !! $request->promoting
        ]);

        $partner->update($request->only('title', 'url', 'promoting', 'category_id'));
        $partner->festivals()->sync($request->post('festivals'));
		$partner->processImages($request);
#        $partner->updateImage($request);

        return response([], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Partner::destroy($request->ids);

        return response([], 200);
    }
}
