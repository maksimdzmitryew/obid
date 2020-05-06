<?php

namespace App\Http\Controllers\Frontend;

use App\Book;
use App\Post;
use App\City;
use App\Event;
use App\Artist;
use App\Festival;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{
    protected $festival;

    public function __construct(Request $request)
    {
        $this->festival = Festival::slug($request->festival_slug)->archived()->firstOrFail();
    }

    public function index()
    {
        $news = $this->festival->news()
            ->limit(4)
            ->get()
            ->each(function($post) {
                $post->type = 'post';
            });

        $medias = $this->festival->medias()
            ->with('file')
            ->limit(4)
            ->get()
            ->each(function($media) {
                $media->type = 'archive-media';
            });

        $presses = $this->festival->presses()
            ->with(['file', 'image'])
            ->limit(4)
            ->get()
            ->each(function($press) {
                $press->type = 'press';
            });

        $posts = $news->merge($medias, $presses)
            ->sortByDesc(function ($post) {
                return $post->created_at;
            })
            ->slice(0, 4);

        return view('public.archive.index', [
            'posts'   => $posts,
            'cities' => City::all(),
        ]);
    }

    public function news(Request $request, $festival_slug)
    {
        return view('public.archive.news', [
            'news' => $this->festival->news()->paginate(20),
            'categories' => Category::type('news')->get(),
        ]);
    }

    public function post(Request $request, $festival_slug, $post_slug)
    {
        $post = $this->festival->news()->whereTranslation('slug', $post_slug)->firstOrFail();

        return view('public.news.single', [
            'news'   => $this->festival->news()
                               ->whereNotIn('id', [$post->id])
                               ->take(4)
                               ->get(),
            'post'   => $post,
            'events' => $this->festival->events()
                                 ->take(4)
                                 ->get()
        ]);
    }

    public function program(Request $request, $festival_slug)
    {
        return view('public.archive.events', [
            'events' => $this->festival->events()->get(),
            'categories' => Category::type('events')->get(),
            'cities' => City::all(),
        ]);
    }

    public function event(Request $request, $festival_slug, $event_slug)
    {
        $event = $this->festival->events()->whereTranslation('slug', $event_slug)->firstOrFail();

        return view('public.program.single', [
            'event'   => $event,
            'cities_event_holdings' => $event->holdings->groupBy('city_id'),
            'promoting_events' => $this->festival->promotingEvents()->get()
        ]);
    }

    public function aboutUs(Request $request)
    {
        return view('public.pages.about-us', [
            'board_members' => Artist::boardMembers()->with('image')->get(),
            'team_members' => Artist::teamMembers()->with('image')->get(),
            'medias' => $this->festival->medias()->with('file')->get(),
        ]);
    }

    public function partners(Request $request)
    {
        return view('public.partners.list', [
            'partner_categories' => Category::type('partners')
                                        ->with(['partners' => function($query) {
                                            $query->where('festival_id', $this->festival->id);
                                        }])
                                        ->get()
        ]);
    }

    public function book(Request $request)
    {
        $book = $this->festival->book;

        return view('public.books.single', [
            'book' => $book,
            'books' => Book::where('id', '!=', $book->id)->get()
        ]);
    }

    public function presses()
    {
        return view('public.press.list', [
            'presses' => $this->festival->presses()->get(),
            'press_categories' => Category::type('presses')->get(),
        ]);
    }

    public function gallery(Request $request)
    {
        $press = $this->festival->presses()->whereTranslation('slug', $request->gallery_slug)->firstOrFail();
        $gallery_parts = $press->gallery->images()->get()->split(4);

        return view('public.press.gallery', [
            'press' => $press,
            'gallery_parts' => $gallery_parts
        ]);
    }
}