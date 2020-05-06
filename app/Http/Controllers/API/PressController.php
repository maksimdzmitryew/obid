<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Press;
use App\Filters\PressFilters;
use App\Http\Requests\PressRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PressApiRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PressController extends Controller
{
    public function index(PressApiRequest $request, PressFilters $filters)
    {
        $presses = Press::filter($filters);

        return response([
            'draw'              => $request->draw,
            'data'              => $presses->with(['image', 'archive', 'file'])->get(),
            'recordsTotal'      => Press::count(),
            'qty_filtered'      => $filters->getFilteredCount(),
            #'sql'               => $presses->toSql(),
        ], 200);
    }

    public function store(PressRequest $request)
    {
        $request->merge([
            'published' => !! $request->published
        ]);

        Press::create($request->only('published_at','gallery_id', 'festival_id', 'category_id', 'city_id', 'type_id', 'en', 'de', 'links', 'published'))
            ->attachFile($request->file_id)
#            ->attachImage($request)
            ->processImages($request)
            ;

        return response([], 200);
    }

    public function update(PressRequest $request, Press $press)
    {
        $request->merge([
            'published' => !! $request->published
        ]);

        $press->update($request->only('published_at','gallery_id', 'festival_id', 'category_id', 'city_id', 'type_id', 'en', 'de', 'links', 'published'));

        $press
			->updateFile($request->file_id)
			->updateArchive($request->file_id)
			->processImages($request)
#            ->updateImage($request)
            ;

//        if($file = File::find($request->image_id))
//            $file->fileable()->associate($press)->save();


        return response([
            'message' => trans('messages.press_updated' )
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Press::destroy($request->ids);

        return response([], 200);
    }
}
