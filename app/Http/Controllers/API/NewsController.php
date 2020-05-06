<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Festival;
use App\Filters\PostFilters;
use App\Http\Requests\PostRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostApiRequest;

class NewsController extends Controller
{
    public function index(PostApiRequest $request, PostFilters $filters)
    {
        return response([
            'draw'              => $request->draw,
            'data'              => Post::filter($filters)->with(['festival', 'event', 'category'])->get(),
            'recordsTotal'      => Post::count(),
            'qty_filtered'      => $filters->getFilteredCount(),
            //'request' => $request->all(),
            //'sql' => Post::filter($filters)->toSql()
        ], 200);
    }

    public function store(PostRequest $request)
    {
        $request->merge([
            'type' => 'news',
            'promoting' => !! $request->promoting,
            'published' => !! $request->published
        ]);

        Post::create(
            $request->only('category_id', 'festival_id', 'event_id', 'gallery_id', 'promoting', 'published', 'published_at', 'en', 'de')
        )->processImages($request, 'image');

        return response([], 200);
    }

    public function update(PostRequest $request, Post $post)
    {
        $request->merge([
            'type' => 'news',
            'promoting' => !! $request->promoting,
            'published' => !! $request->published
        ]);

        $post->update($request->only('category_id', 'festival_id', 'event_id', 'gallery_id', 'promoting', 'published', 'published_at', 'en', 'de'));
        $post->processImages($request, 'image');
        #$post->updateImage($request);

        return response(['updated'], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Post::destroy($request->ids);

        return response([], 200);
    }
}
