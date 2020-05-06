<?php

namespace App\Http\Controllers\API;
use App\Event;
use App\Artist;
use App\EventHolding;
use App\Vocation;
use App\EventCategory;
use App\Traits\FestivalTrait;
use App\Traits\DatesTrait;
use App\Filters\EventFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventApiRequest;
use App\Http\Requests\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use DatesTrait;
    use FestivalTrait {
        FestivalTrait::__construct as protected __traitConstruct;
    }

    public function index(EventApiRequest $request, EventFilters $filters)
    {
        $events = Event::filter($filters)
            ->with(['category', 'festival'])
            ->get()
            ->each(function($event) {
                $event->is_favorited = $event->isFavorited();
            });

        return response([
            'draw'              => $request->draw,
            'data'              => $events,
            'recordsTotal'      => Event::count(),
            'qty_filtered'      => $filters->getFilteredCount(),
        ]);
    }

    public function store(EventRequest $request)
    {
        $request->merge([
            'promoting_up' => !! $request->promoting_up,
            'promoting' => !! $request->promoting,
            'published' => !! $request->published
        ]);

        $groups = $this->dispatchArtists($request->artists);

        $event = Event::create($request->only('festival_id', 'category_id', 'gallery_id', 'en', 'de', 'facebook', 'promoting_up', 'promoting', 'published'));

        $event->processImages($request, 'image');
        #$event->attachImage($request);
        $event->directors()->sync($groups['director']);
        $event->artists()->sync($groups['artist']);
        $event->producers()->sync($groups['producer']);
        $event->executiveProducers()->sync($groups['executive_producer']);
        $event->holdings()->saveMany(array_map(function($holding) {
                return new EventHolding($holding);
            }, $request->holdings)
        );

        return response([
            'message' => trans('messages.event_created')
        ], 200);
    }

    public function update(EventRequest $request, Event $event)
    {
        $request->merge([
            'promoting_up' => !! $request->promoting_up,
            'promoting' => !! $request->promoting,
            'published' => !! $request->published
        ]);

        $groups = $this->dispatchArtists($request->artists);
dd($request);
        $event->update($request->only('festival_id', 'category_id', 'gallery_id', 'en', 'de', 'facebook', 'promoting_up', 'promoting', 'published'));
        $event->processImages($request, 'image');
        #$event->updateImage($request);
        $event->directors()->sync($groups['director']);
        $event->artists()->sync($groups['artist']);
        $event->producers()->sync($groups['producer']);
        $event->executiveProducers()->sync($groups['executive_producer']);
        $event->holdings()->delete();
        $event->holdings()->saveMany(array_map(function($holding) {
                return new EventHolding($holding);
            }, $request->holdings)
        );
        $event->vocations()->sync($this->arrayWithOrder($request->vocations));
        if(isset($request->vocations) && $request->vocations) {
            foreach ($request->vocations as $key => $vocation) {
                $event->eventVocations()->where('vocation_id','=',$vocation['vocation_id'])->first()->artists()->sync($this->arrayWithOrder($vocation['artists'],'artist_id'));
            }
        }

        return response([
            'message' => trans('messages.event_updated' )
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        $number = count($request->ids);

        Event::destroy($request->ids);

        return response([
            'message' => trans_choice('messages.events_deleted', $number, ['number' => $number])
        ], 200);
    }

    public function program(Request $request)
    {
        return response($this->getEventsList($request));
//
//        $event_ids = Event::filter($filters)->select('events.id')->get()->map->id->toArray();
//        $amount = $request->amount && $request->amount < 100 ? $request->amount : 20;
//
//        $holdings = EventHolding::whereIn('event_id', $event_ids)
//            ->whereBetween('date_from', $request->filters['holdings']);
//
//        $holdings_count = $holdings->count();
//
//        $holdings = $holdings->offset($request->offset)
//            ->limit($amount)
//            ->get();
//
//        $event_dates = $holdings
//            // group event holdings by date into format
//            ->groupBy(function($holding) {
//                return $holding->date_from->format('Y-m-d');
//            });
//
//        // modifing got event holdings
//        $event_dates = $holdings
//            // group event holdings by date into format
//            ->groupBy(function($holding) {
//                return $holding->date_from->format('Y-m-d');
//            })
//            // getting holdings with unique event_id and getting events with holdings not to lazy load them from them
//            ->map(function($date_from) {
//                return $date_from->unique->event_id->map(function($holding) {
//                    $event = $holding->event;
//                    $event->is_favorited = $event->isFavorited();
//                    return $event;
//                })->values();
//            });
//
//        return response([
//            'data' => $event_dates,
//            'total' => $holdings_count
//        ]);
    }

    //Put ids of artists into dedicated groups
    protected function dispatchArtists($request_groups)
    {
        $group_names = [
            'executive_producers',
            'directors',
            'artists',
            'producers'
        ];

        foreach($group_names as $group_name) {
            $role = str_singular($group_name);

            if(isset($request_groups[$group_name])) {
                foreach($request_groups[$group_name] as $artist_id) {
                    $groups[$role][$artist_id] = ['role' => $role];
                }
            } else {
                $groups[$role] = [];
            }
        }

        return $groups;
    }

    public function favoritedEvents(Request $request, EventFilters $filters)
    {
        $event_ids = Auth::user()->favoritedEvents()
            ->filter($filters)
            ->select('events.id')
            ->get()
            ->map
            ->id
            ->toArray();

        $amount = $request->amount && $request->amount < 100 ? $request->amount : 20;

        $holdings = EventHolding::whereIn('event_id', $event_ids)
            ->whereBetween('date_from', $request->filters['holdings']);


        $holdings_count = $holdings->count();

        $holdings = $holdings->offset($request->offset)
            ->limit($amount)
            ->get();

        // modifing got event holdings
        $event_dates = $holdings
            // removing old holdings
            ->filter(function($holding) use ($request){
                return $holding->date_from > $request->filters['holdings']['from'];
            })
            // removing not unique items
            ->unique->event_id
            // group event holdings by date into format
            ->groupBy(function($holding) {
                return $holding->date_from->format('j F Y');
            })
            // getting holdings with unique event_id and getting events with holdings not to lazy load them from them
            ->map(function($date) {
                return $date->map(function($holding) {
                    $event = $holding->event;
                    $event->is_favorited = $event->isFavorited();

                    return $event;
                });
            });

        return response([
            'data' => $event_dates,
            'total' => $holdings_count
        ]);
    }

    public function arrayWithOrder($array = [], $fieldname = 'vocation_id')
    {
        $result = [];
        $order = 0;
        if ($array){
            foreach ($array as $key => $vocation) {
                $result[$vocation[$fieldname]] = ['order' => $order];
                $order++;
            }
        }
        return $result;
    }

}
