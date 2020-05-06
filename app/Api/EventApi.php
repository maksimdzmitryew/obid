<?php

namespace App\Api;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventApi{

    private $query;

    public function __construct(Request $request = null)
    {
        $this->query = Event::select(
            'events.*',
            DB::raw('DATE_FORMAT(date_from, "%Y-%m-%d") as day')
        )->join('event_holdings', 'events.id', '=', 'event_holdings.event_id');

        $filters = $request->filters ?? [];

        foreach($filters as $filter => $arg){
            $this->filter($filter, $arg);
        }

        $this->order([
            'column'    => $request->column ?? 'day',
            'direction' => $request->direction ?? 'asc',
        ]);

        $this->offset($request->offset ?? 0);

        $this->limit($request->limit ?? 20);

        return $this->query;
    }

    public function __call($name, $arguments)
    {
        return call_user_func([$this->query, $name], ...$arguments);
    }

    function filter($filter, $arg)
    {
        $class_method = [$this, $filter];

        if(is_callable($class_method) && $arg){
            call_user_func($class_method, $arg);
        }

        return $this;
    }

    function favorites($user_id)
    {
        return $this->query->join('favorites', 'favorites.favorited_id', '=', 'events.id')->where('favorites.user_id', $user_id);
    }

    function published($published)
    {
        return $this->query->where('events.published', $published);
    }

    function festivals($festivals)
    {
        return $this->query->whereIn('events.festival_id', (array) $festivals);
    }

    function categories($categories)
    {
        return $this->query->whereIn('events.category_id', (array) $categories);
    }

    function holdings($holdings)
    {
        $from = $holdings['from'] ?? $holdings['from'];
        $to = $holdings['to'] ?? $holdings['from'];

        return $this->query->whereBetween('event_holdings.date_from', [
            (new Carbon($from))->startOfDay(),
            (new Carbon($to))->endOfDay()
        ]);
    }

    function cities($cities)
    {
        return $this->query->whereIn('event_holdings.city_id', (array) $cities);
    }

    function order($order)
    {
        return $this->query->orderBy($order['column'], $order['direction']);
    }

    function offset($offset)
    {
        return $this->query->offset($offset);
    }

    function limit($limit)
    {
        return $this->query->limit($limit);
    }




}