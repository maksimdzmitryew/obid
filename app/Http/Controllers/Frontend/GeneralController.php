<?php

namespace App\Http\Controllers\Frontend;

use App\File;
use App\City;
use App\Post;
use App\Event;
use App\Festival;
use App\Category;
use App\Settings;
use App\EventHolding;
use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        $festival = Festival::current();

        $event_dates = $this->getClosestEventDates($festival);

        $promoting_events = Event::first() ?
            $festival->events()->promoting()->take(2)->get() :
            collect();

        $news = Post::first() ?
            $festival->news()->take(4)->get() :
            collect();

        // TODO refactoring: almost same method exists in FestivalTrait@getPressCities
        $cities = City::select('cities.*')
            ->leftJoin('city_translations', 'cities.id', '=', 'city_translations.city_id')
            ->leftJoin('event_holdings', 'event_holdings.city_id', '=', 'cities.id')
            ->leftJoin('events', 'event_holdings.event_id', '=', 'events.id')
            ->where([
                'events.festival_id' => $festival->id,
                'city_translations.locale' => App::getLocale()
            ])
            ->groupBy('cities.id')
            ->get();

        return view('public.app', [
            'event_dates' => $event_dates,
            'promoting_events' => $promoting_events,
            'news'   => $news,
            'cities' => $cities
        ]);
    }

	public function showImage($image_id, $show_marker = '', $image_size = '')
	{#dd($image_size, $show_marker);
		$o_res = File::findOrFail($image_id);
		return $o_res->showImage($image_size);
	}

	public function downloadImage($image_id)
	{
		$res = File::findOrFail($image_id);
		return $res->downloadImage($image_id);
	}

    public function contactUs(Request $request, Settings $settings)
    {
        $this->validate($request, [
            'message' => 'required|string'
        ]);

        Mail::send('emails.contact-us', ['email' => $request->post('email'), 'text' => $request->message], function($message) {
            $message->from(config('services.mail.from'), config('services.mail.name'))->to(config('services.mail.from'))->subject('New Contact Us');
        });

        //Mail::to('culturescapes2018@gmail.com')->send(new ContactUs($request));

        return response([
            'message' => trans('messages.contact.success')
        ], 200);

        //return back()->with(['message' => 'Thank you!']);
    }

    protected function getClosestEventDates($festival)
    {
        if ( ! $festival->count() || ! $festival->holdings()->where('date_from', '>', today())->exists()) {
            return collect();
        }

        $closest_date = $festival->holdings()
            ->where('date_from', '>', today()
            ->toDateString())
            ->first();

        if($closest_date)
            $closest_date = $closest_date->date_from->endOfDay();

        $second_closest_date = $festival->holdings()
            ->where('date_from', '>', $closest_date)
            ->first();

        if($second_closest_date)
            $second_closest_date = $second_closest_date->date_from->endOfDay();

        $closest_holdings = $festival->holdings()
            ->whereBetween('date_from', [$closest_date->startOfDay(), $second_closest_date])
            ->orderBy('date_from')
            ->get();

        // modifing got event holdings
        return $closest_holdings
            // group event holdings by date into format
            ->groupBy(function($holding) {
                return $holding->date_from->format('j F Y');
            })
            // getting holdings with unique event_id and getting events with holdings not to lazy load them from them
            ->map(function($date_from) {
                return $date_from->unique->event_id->map(function($holding) {
                    return $holding->event;
                });
            });
    }
}
