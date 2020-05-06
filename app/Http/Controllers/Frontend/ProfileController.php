<?php

namespace App\Http\Controllers\Frontend;

use App\Api\EventApi;
use App\Event;
#use App\Traits\FestivalTrait;
use Auth;
use Hash;
use App\User;
use Validator;
use App\Subscriber;
use Illuminate\Http\Request;
#use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerGuest as Controller;

class ProfileController extends Controller
{
/*
    use FestivalTrait {
        FestivalTrait::__construct as protected __traitConstruct;
    }

    public function __construct(Request $request){
        $this->__traitConstruct($request);
    }
*/
    public function cabinet(Request $request)
    {

		$this->setEnv();

        $user = Auth::user();
/*
        $input = $request->all();

        $input['filters']['published'] = 1;
        $input['filters']['favorites'] = $user->id;

        $events = new EventApi($request->replace($input));

        $events = $events->get()->groupBy(function($event) use ($request){
            return $event->day;
        });
*/
        return view('public.profile.miy-pr', [
            'user' => $user,
            'b_admin' => $user->checkAdmin(),
            #'subscribe' => Subscriber::where('email', $user->email)->exists(),
            #'event_dates' => $events,
            #'dates' => $this->getFavoriteDates(),
            'cities' => $this->getCities()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'first_name'	=> 'required|string|max:255',
            'last_name'		=> 'required|string|max:255',
            'email'			=> 'required|string|email|max:255|unique:users,email,' . $user->id,
            'old_password'	=> 'nullable|string|min:6',
            'password'		=> 'nullable|string|min:6|confirmed',
            'subscribe'		=> 'nullable|boolean',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->password) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors([
                    'old_password' => 'Given data does not match any record'
                ])->withInput();
            }

            $user->password = bcrypt($request->password);
        }

        if ($request->subscribe) {
            if (!Subscriber::where('email', $user->email)->exists()) {
                Subscriber::create(['email' => $user->email]);
            }
        } else {
            if ($subscriber = Subscriber::where('email', $user->email)->first()) {
                $subscriber->delete();
            }
        }

        $user->save();

        return back();
    }

    function favoriteEvents(Request $request)
    {
        $user = Auth::user();

        $input = $request->all();

        $input['filters']['published'] = 1;
        $input['filters']['favorites'] = $user->id;

        $events = new EventApi($request->replace($input));

        $data = $events->get()->groupBy(function($event) use ($request){
            return $event->getOriginal('day');
        });

        return response([
            'data' => $data,
            'total' => $events->count()
        ]);
    }

    function getFavoriteDates()
    {
        $user = Auth::user();

        $events = Event::select('event_holdings.date_from')
            ->join('event_holdings', 'events.id', '=', 'event_holdings.event_id')
            ->join('favorites', 'events.id', '=', 'favorites.favorited_id')
            ->where([
                'favorites.user_id' => $user->id,
                'events.published' => 1
            ]);

        //dd($events->min('date_from'), $events->max('date_from'));

        $dates = [
            'from' => $events->min('date_from'),
            'to' => $events->max('date_from')
        ];

        return collect($dates);
    }

}
