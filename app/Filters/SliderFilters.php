<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class SliderFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'festival',
        'created_at',
        'updated_at'
    ];

    protected function name($name)
    {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }

    protected function festival($festivals)
    {
        return $this->builder->whereIn('festival_id', $festivals);
    }
}
