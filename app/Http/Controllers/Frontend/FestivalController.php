<?php

namespace App\Http\Controllers\Frontend;

use App\Api\EventApi;
use App\Artist;
use App\Book;
use App\Category;
use App\City;
use App\Event;
use App\EventHolding;
use App\Festival;
use App\Filters\EventFilters;
use App\Media;
use App\Post;
use App\Traits\DatesTrait;
use App\Traits\FestivalTrait;
use App\Traits\EventTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FestivalController extends Controller
{

    use DatesTrait;

    use FestivalTrait {
        FestivalTrait::__construct as protected __traitConstruct;
    }

    public function __construct(Request $request){
        $this->__traitConstruct($request);
    }

    public function index(Request $request){
die('FestivalController index');
    	return redirect(route('login'));

        $a_res = $this->getEventsList($request);

        return view('public.app', [
            'dates_filtered'        => $a_res['dates_filtered'],
            'dates_range'           => $a_res['dates_range'],
            'events_list'           => $a_res['data'],
            'records_total'         => $a_res['records_total'],
            'expired_events'        => $this->getExpiredEvents(15),
            'promoting_up_events'   => $this->getPromotionUpEvents(),
            'promoting_events'      => $this->getPromotionEvents(),
            'cities'                => $this->getCities(),
            'news'                  => $this->getNews(),
            'categories'            => collect(request()->get('categories')),
        ]);
    }

    public function program(Request $request){

        $a_res = $this->getEventsList($request);
        return view('public.program.list', [
            'dates_filtered'        => $a_res['dates_filtered'],
            'dates_range'           => $a_res['dates_range'],
            'events_list'           => $a_res['data'],
            'records_total'         => $a_res['records_total'],
            'expired_events'        => $this->getExpiredEvents(15),
            'promoting_up_events'   => $this->getPromotionUpEvents(),
            'promoting_events'      => $this->getPromotionEvents(),
            'cities'                => $this->getCities(),
            'categories'            => collect(request()->get('categories')),
        ]);
    }

    public function event(Request $request){

        $event = $this->festival->events()->whereTranslation('slug', $request->event_slug)->where('published', 1)->firstOrFail();

        return view('public.program.single', [
            'event'                 => $event,
            'cities_event_holdings' => $event->holdings->groupBy('city_id'),
            'promoting_events'      => $this->festival->promotingEvents()->where('id', '!=', $event->id)->where('published', 1)->with('holdings')->get()
        ]);
    }


    public function news(Request $request){
        $news = $this->festival->news()->where('published', 1)->orderBy('published_at', 'desc');
        $current_category = $request->get('category');

        if($current_category)
            $news = $news->whereHas('category', function($query) use ($current_category){
                return $query->where([
                    'type' => 'news',
                    'id' => $current_category
                ]);
            });

        return view('public.news.list', [
            'news'              => $news->paginate(20),
            'categories'        => Category::type('news')->get(),
            'current_category'  => $current_category
        ]);
    }

    public function post(Request $request){

        return view('public.news.single', [
            'post'      => $this->festival->news()->where('published', 1)->whereTranslation('slug', $request->post_slug)->firstOrFail(),
            'news'      => $this->festival->news()->where('published', 1)->take(4)->get(),
            'events'    => $this->festival->events()->promoting()->with('holdings')->orderBy('created_at', 'desc')->take(10)->get()
        ]);
    }

    public function books(Request $request){
        $book = $this->festival->book()->whereTranslation('slug', $request->book_slug)->firstOrFail();
        $book = $book ? $book : $this->festival->book;
        return view('public.books.single', [
            'book' => $book,
            'books' => Book::where('id', '!=', $book->id)->get()
        ]);
    }


	public function partners()
	{
		$o_cats 					= $this->getCategoriesList();
		$o_partners 				= $this->getPartnersFromCategory($o_cats);
		return view('public.partners.list', [
			'partner_categories' 	=> $o_cats,
			'partners' 				=> $o_partners,
		]);
	}

	public function press()
	{
		return view('public.press.list', [
			'presses'				=> $this->festival->presses()->where('published', 1)->orderBy('published_at', 'desc')->get(),
			'medias'				=> $this->getMedia(),
			'cities'				=> $this->getPressCities(),
			'dates_range'			=> $this->getDatesRangePress(),
		]);
	}

    public function gallery(Request $request){

        $press = $this->festival->presses()->whereTranslation('slug', $request->gallery_slug)->firstOrFail();
        $gallery_parts = $press->gallery->images()->get()->split(4);

        return view('public.press.gallery', [
            'press' => $press,
            'gallery_parts' => $gallery_parts
        ]);

    }

    public function about(){
        return view('public.pages.about-us', [
            'board_members' => $this->festival->artists()->festivalProfession()->festivalBoard()->get(['artists.*', 'pt.name as profession']),
            'team_members' => $this->festival->artists()->festivalProfession()->festivalTeam()->get(['artists.*', 'pt.name as profession']),
            'medias' => $this->festival->medias()->where('published', 1)->get(),
        ]);
    }

    private function getClosestDates($days = 3){
        $day = DB::raw('DATE_FORMAT(date_from, "%Y-%m-%d") as day');

        $query = $this->festival->holdings()
            ->select($day)
            ->distinct()
            ->having('day', '>', now()->toDateString())
            ->take($days);

         return $query->get()->pluck('day');
    }

    private function getClosestEvents($days = 3){
        $categories = request()->get('categories');

        $day = DB::raw('DATE_FORMAT(date_from, "%Y-%m-%d") as day');

        $events = Event::select('events.*', DB::raw($day))
            ->join('event_holdings', 'events.id', '=', 'event_holdings.event_id')
            ->where('events.festival_id', $this->festival->id);

        if($categories)
            $events = $events->whereIn('events.category_id', $categories);
        else{
            $dates = $this->getClosestDates($days);

            if( ! $dates->count()) return collect();

            $events = $events
                ->whereBetween('event_holdings.date_from', [(new Carbon($dates->first()))->startOfDay(), (new Carbon($dates->last()))->endOfDay()])
                ->orderBy('date_from', 'asc');
        }

        return $events->get()->groupBy(function($event){
            $date = new Carbon($event->day);

            return trans('general.date', [
                'day'   => $date->format('j'),
                'month' => $date->format('F'),
                'year'  => $date->format('Y')
            ]);
        });
    }

    private function getExpiredEvents($count = 15){

        //$max_day = DB::raw('max(date_from)');

        $result = Event::select('events.*')
            ->join('event_holdings','event_holdings.event_id', '=', 'events.id')
            ->where('events.festival_id', $this->festival->id)
            ->limit($count)
            ->groupBy('events.id')
            ->orderBy('date_from', 'desc')
            ->get();

        return $result;
    }

    private function getPromotionEvents(){
        return Event::first() ? $this->festival->events()->where([
            'published' => 1
        ])->promoting()->take(2)->get() : collect();
    }

    private function getPromotionUpEvents(){
        return Event::first() ? $this->festival->events()->where([
            'promoting_up'  => 1,
            'published'     => 1
        ])->take(2)->get() : collect();
    }

    // TODO similar to getNews() below
    private function getMedia(){

        $media = $this->festival->medias()->where('published', 1)->orderBy('published_at', 'desc')->get();
        $collection = collect();
        foreach ($media as $item){
            $instance = Media::find($item->id);
			$instance->published_at_day = self::getSpellDate($item->published_at);
            $collection->push($instance);
        }
        return $collection;
    }

    // TODO similar to getMedia() above
    private function getNews(){

        $media = $this->festival->medias()->where([
            'promoting' => 1,
            'published' => 1
        ])->select(['id', 'promoting', 'created_at', 'published_at', DB::raw("'medias' as type")]);

        $news = $this->festival->news()->where([
            'promoting' => 1,
            'published' => 1
        ])->select(['id', 'promoting', 'created_at', 'published_at', DB::raw("'news' as type")]);

        $news_media = $news->union($media)->orderBy('published_at', 'desc')->take(4)->get();

        $collection = collect();

        foreach ($news_media as $item){
            $instance = ($item->type === 'medias') ? Media::find($item->id) : Post::find($item->id);

            $instance->type = $item->type;
			$instance->published_at_day = self::getSpellDate($item->published_at);

            $collection->push($instance);
        }
        return $collection->count() ? $collection : collect();
    }

}
