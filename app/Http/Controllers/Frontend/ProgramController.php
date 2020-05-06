<?php

namespace App\Http\Controllers\Frontend;

use DB;
use App\City;
use App\Event;
use App\Category;
use App\Festival;
use App\EventHolding;
use Illuminate\Http\Request;
use App\Filters\EventFilters;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ProgramController extends Controller
{
    public function event(Request $request, $slug)
    {
        $festival = Festival::current();
        $event = $festival->events()->whereTranslation('slug', $slug)->firstOrFail();

        return view('public.program.single', [
            'event' => $event,
            'cities_event_holdings' => $event->holdings->groupBy('city_id'),
            'promoting_events' => $festival->promotingEvents()->where('id', '!=', $event->id)->with('holdings')->get()
        ]);
    }

    public function program(Request $request)
    {
    	$festival = Festival::current();

        $event_dates = $this->getClosestEventDates($festival);

        $promoting_events = Event::first() ?
            $festival->events()->promoting()->take(2)->get() :
            collect();

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

        return view('public.program.list', [
            'event_dates' => $event_dates,
            'promoting_events' => $promoting_events,
            'cities' => $cities
        ]);
    }

    public function favorite(Request $request, Event $event)
    {
        $event->favorite();

        return response([
            'message' => trans('messages.favorite')
        ], 200);
    }

    public function unfavorite(Request $request, Event $event)
    {
        $event->unfavorite();

        return response([
            'message' => trans('messages.unfavorite')
        ], 200);
    }

    protected function getClosestEventDates($festival)
    {
        if (!$festival->holdings()->where('date_from', '>', today())->exists()) {
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
