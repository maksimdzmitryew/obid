<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Filters\UserFilters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserApiRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DeleteRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserController extends Controller
{
    public function index(UserApiRequest $request, UserFilters $filters)
    {
        $users = User::filter($filters);
        return response([
            'draw' => $request->draw,
            'data' => $users->with('roles')->get(),
            'recordsTotal' => User::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(UserCreateRequest $request)
    {

        $user               = new User();
#        $user->country_id   = $request->country_id;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email        = $request->email;
        $user->enabled      = $request->enabled ? 1 : 0 ?? 0;
        $user->password     = bcrypt($request->password);
        $user->save();

        $user->syncRoles($request->role);

        return response([
            'user_id' => $user->id,
            'message' => trans('messages.user_created'),
        ], 200);
    }

    public function update(UserUpdateRequest $request, User $item)
    {
#    	$data = $request->only('country_id', 'email', 'first_name', 'last_name', 'enabled');
    	$data = $request->only('email', 'first_name', 'last_name', 'enabled');
    	$data['enabled'] = $request->enabled ? 1 : 0 ?? 0;

        $item->update($data);
        $item->syncRoles($request->role);

        return response([
            'message' => trans('user/messages.text.updated'),
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        User::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.users_deleted', $number, ['number' => $number])
        ], 200);
    }

    public function passwordChange(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->post(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $validator->after(function($validator) use ($request, $user){
            if( ! Hash::check($request->post('old_password'), $user->password))
                $validator->errors()->add('old_password', 'Old password not correct');
        });

        if ($validator->fails()) {
            return response([
                'message' => trans('validation/status.422'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response([
            'user_id' => $user->id,
            'message' => trans('messages.user_password_changed'),
        ], 200);
    }
}
