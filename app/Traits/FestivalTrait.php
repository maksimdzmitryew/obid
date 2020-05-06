<?php

namespace App\Traits;

use App\Event;
use App\Category;
use App\City;
use App\Festival;
use App\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

trait FestivalTrait{

    protected $festivals = [];

    protected $festival = null;

    public function __construct(Request $request = null){
        if($festival = Festival::where('published', 1)->whereTranslation('slug', $request->segment(1))->first())
            $this->festival = $festival;
        elseif(($festival = Festival::current())->count())
            $this->festival = $festival;
        else
            $this->festival = Festival::where('published', 1)->orderBy('year', 'desc')->get()->first();

        if( ! $this->festival) abort(404);

        View::composer('public.*', function($view){
            $view->with([
                'festival'              => $this->festival,
                'promoting_partners'    => $this->getPromotingPartners(),
                'festivals'             => $this->getFestivals(),
            ]);
        });

    }

	private function getCategoriesList() : object
	{
		return Category::type('partners')->get();
	}

    /**
    * Partners list of current festival for specified list of categories
    *
    * @param Object 	$o_cats 		list of categories
    *
    * return object of cities
    **/
	private function getPartnersFromCategory(Object $o_cats) : object
	{
    	$o_res = new \stdClass();
        foreach($o_cats as $category)
        {
        	$o_res->{$category->slug} = $this->festival->partners()
        									->where('category_id', $category->id)
        									->orderBy('title')->orderBy('url')
        									->get()
    									;
        }
		return $o_res;
	}

    public function getPromotingPartners(){
        return $this->festival->partners()->promoting()->take(4)->get();
    }

    protected function getFestivals(){
        return Festival::where('published', 1)->orderBy('year', 'desc')->get()->sort(function($a, $b){
            return $this->festival->id === $b->id ? 1 : 0;
        });
    }

    /**
    * Read from DB only those cities that have press records under current festival
    *
    * @param void
    *
    * return object of cities
    **/
    // TODO refactoring: almost same functionality exists in GeneralController@index
    private function getPressCities(){
      return City::select('cities.*')
          ->leftJoin('city_translations', 'cities.id', '=', 'city_translations.city_id')
          ->leftJoin('presses', 'presses.city_id', '=', 'cities.id')
          ->where([
              'presses.festival_id' => $this->festival->id,
              'city_translations.locale' => App::getLocale()
          ])
          ->groupBy('cities.id')
          ->orderBy('city_translations.name')
          ->get();
    }

    private function getCities(){

        return City::select('cities.*')
            ->leftJoin('city_translations', 'cities.id', '=', 'city_translations.city_id')
            ->leftJoin('event_holdings', 'event_holdings.city_id', '=', 'cities.id')
            ->leftJoin('events', 'event_holdings.event_id', '=', 'events.id')
            ->where([
                'events.festival_id' => $this->festival->id,
                'city_translations.locale' => App::getLocale()
            ])
            ->groupBy('cities.id')
            ->orderBy('city_translations.name')
            ->get();

    }

    private function getEventsList(Request $request)
    {

        $day = DB::raw('DATE_FORMAT(date_from, "%Y-%m-%d") as day');

        $events = Event::select('events.*', DB::raw($day))
            ->join('event_holdings', 'events.id', '=', 'event_holdings.event_id')
            ->where('published', 1)
            ;

        $filters = $request->filters;
#dd($filters['holdings']);
        $dates = collect($filters['holdings'] ?? null);

        if($dates->count()){
            # filter events by date from calendar picker

            $dates_carbon = $this->getDatesRange($dates);

            $events->where(function ($query) use ($dates_carbon)
            {
                #$query
                #    ->whereDate('date_from', '>=', $dates_carbon[0])
                #    ->orWhere(function($query) use ($dates_carbon)
                #    {
                    $query
                        ->WhereDate('date_from', '<=', $dates_carbon[1])
                        ->whereDate('date_to', '>=', $dates_carbon[0])
                    ;
                #    })
                #;
            });

            #$events = $events
            #    ->whereBetween('event_holdings.date_from', $this->getDatesRange($dates));

#dd($this->getDatesRange($dates));

        } else {
            if ($this->festival->active)
            {
                # show only current or future events
                # skip events in the past
                $events->where(function ($query)
                {
                    $query
                        ->whereDate('date_from', '>=', Carbon::today())
                        ->orWhere(function($query)
                        {
                        $query
                            ->WhereDate('date_from', '<=', Carbon::today())
                            ->whereDate('date_to', '>=', Carbon::today())
                        ;
                        })
                    ;
                });
            }
        }

        $festivals = $filters['festivals'] ?? array($this->festival->id);

        if($festivals){
            $events = $events->whereIn('events.festival_id', $festivals);
        }

        $cities = $filters['cities'] ?? null;

        if($cities){
            $events = $events->whereIn('event_holdings.city_id', $cities);
        }

        $categories = $filters['categories'] ?? null;
        $categories = $request->categories ?? $categories;

        if($categories){
            $events = $events->whereIn('events.category_id', $categories);
        }

        $offset = $request->offset ?? 0;

        $limit = $request->limit ?? 10;

        $data = $events
                    ->orderBy('date_from', 'asc')
                    ->get()
                    ->groupBy(function($event)
        {
			return self::getSpellDate($event->day);
        });

        $i_total = $data->count();
        $data = $data->splice($offset, $limit);

#dd($events->toSql(), $events->getBindings());

        $dates_range = $this->getDatesRangeHoldings();
        if ($this->festival->active)
        {
            if ((new Carbon( $dates_range[0] ))->startOfDay() < Carbon::now()) {
                $dates_range[0] = date("r");
            }
        }

        return [
            'data'              => $data,
            'records_total'     => $i_total,
            'dates_filtered'    => $this->getDatesFiltered($dates),
            'dates_range'       => $dates_range,
            #'holdings'          => [
            #    (new Carbon($dates->first()))->startOfDay(),
            #    (new Carbon($dates->last()))->endOfDay(),
            #],
        ];
    }

/*
    private function getHoldingDates(){

        $a_res = [
            'min' => $this->festival->holdings()->min('date_from'),
            'max' => $this->festival->holdings()->max('date_from')
        ];

        $a_res['min'] = $this->getDateParsed($a_res['min']);
        $a_res['max'] = $this->getDateParsed($a_res['max']);

        return $a_res;
    }
*/
}
