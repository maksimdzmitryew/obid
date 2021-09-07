<?php

namespace App\Filters;

use Illuminate\Support\Facades\DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class UserFilters extends Filters
{
    protected $filters = [
        'id',
        'roles',
        'email',
        'last_name',
        'first_name',
        'created_at',
        'updated_at',
    ];

    protected function roles($roles)
    {
        return $this->builder
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->whereIn('model_has_roles.role_id', $roles);
    }

    protected function last_name($last_name)
    {
        return $this->builder->where('last_name', 'like', '%'. $last_name .'%');
    }

    protected function first_name($first_name)
    {
        return $this->builder->where('first_name', 'like', '%'. $first_name .'%');
    }

    protected function email($email)
    {
        return $this->builder->where('email', 'like', '%'. $email . '%');
    }

    protected function getQuery()
    {
        return $this->builder->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.published'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}
