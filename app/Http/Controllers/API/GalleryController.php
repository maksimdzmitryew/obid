<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Gallery;
use App\Filters\GalleryFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\GalleryRequest;
use App\Http\Requests\GalleryApiRequest;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GalleryApiRequest $request, GalleryFilters $filters)
    {
        return response()->json([
            'draw'            => $request->draw,
            'data'            => Gallery::filter($filters)->get(),
            'recordsTotal'    => Gallery::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $gallery = Gallery::create($request->only('name'));

        $positions = array_flip($request->image_ids);

        File::whereIn('id', $request->image_ids)->get()
            ->each(function($file, $position) use ($gallery, $positions) {
                $file->fileable()->associate($gallery);
                $file->position = $positions[$file->id];
                $file->type = 'gallery_item';
                $file->save();
            }
        );

        return response([], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->only('name'));

        $gallery->processImages($request, 'gallery_item');
/*
        File::destroy(array_diff(
            $gallery->images->map->id->toArray(), $request->image_ids
        ));

        $positions = array_flip($request->image_ids);

        File::whereIn('id', $request->image_ids)->get()
            ->each(function($file, $position) use ($gallery, $positions) {
                $file->fileable()->associate($gallery);
                $file->position = $positions[$file->id];
                $file->type = 'gallery_item';
                $file->save();
            }
        );
        */

        return response([
            'message' => trans('messages.gallery_updated' )
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request)
    {
        Gallery::destroy($request->ids);

        return response([], 200);
    }
}
