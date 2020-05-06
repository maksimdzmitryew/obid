<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Country;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.list', [
            'dates'       => User::getTimestampDates(),
            'roles'       => Role::all()
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        return view('admin.users.form', [
            'user'			=> User::findOrNew($request->id),
            'countries'   	=> Country::published()->get()->sortBy('name'),
            'roles'			=> Role::all()
        ]);
    }
}
