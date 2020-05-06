<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Filters\CategoryFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\CategoryApiRequest;

class CategoryController extends Controller
{
    public function index(CategoryApiRequest $request, CategoryFilters $filters)
    {
        $categories = Category::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $categories->get(),
            'recordsTotal'    => Category::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->only('type', 'en', 'de'));

        return response([
            'message' => trans('messages.category_created')
        ], 200);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->only('type', 'en', 'de'));

        return response([
            'message' => trans('messages.category_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Category::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.categories_deleted', $number, ['number' => $number])
        ], 200);
    }
}
