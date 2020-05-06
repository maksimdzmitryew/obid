<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class GalleryFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    protected function name($name)
    {
        return $this->builder->where('name', 'like', $name .'%');
    }
}