<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SubscribeRequest;
use App\User;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

use App\Events\UserRegistered;

class SubscribeController extends Controller
{
    public function store(SubscribeRequest $request)
    {
        Subscriber::create($request->only('email'));

        $user = new User();
        $user->email = $request->post('email');

        event(new UserRegistered($user));

        Mail::send('emails.subscribe', ['email' => $request->post('email')], function($message) use ($request) {
            $message->from(config('services.mail.from'), config('services.mail.name'))->to(config('services.mail.to'))->subject('New subscriber');
        });

        return response([
            'message' => 'subscription successfully completed'
        ], 200);
    }

    public function delete(DeleteRequest $request)
    {
        Subscriber::destroy($request->ids);

        return response([], 200);
    }
}