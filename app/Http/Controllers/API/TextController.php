<?php

namespace App\Http\Controllers\API;

use App\Text;
use App\Filters\TextFilters;
use App\Http\Requests\TextRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\TextApiRequest;

class TextController extends Controller
{
    public function index(TextApiRequest $request, TextFilters $filters)
    {
        $texts = Text::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $texts->get(),
            'recordsTotal'    => Text::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(TextRequest $request)
    {
        $text = Text::create($request->only('en', 'de'));

        return response([
            'message' => trans('messages.text_created')
        ], 200);
    }

    public function update(TextRequest $request, Text $text)
    {
        $text->update($request->only('en', 'de'));

        return response([
            'message' => trans('messages.text_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Text::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans('common/messages.texts_deleted')
        ], 200);
    }
}
