<?php

namespace App\Http\Controllers\Frontend;

#use App\Festival;
#use App\Traits\FestivalTrait;
use App\Http\Requests\SearchRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
#    use FestivalTrait {
#        FestivalTrait::__construct as protected __traitConstruct;
#    }

    public function __construct(Request $request){
        $this->__traitConstruct($request);
    }
/*    
    protected $festival;

    public function __construct(Request $request){

        if($festival = Festival::whereTranslation('slug', $request->segment(1))->first())
            $this->festival = $festival;
        elseif(($festival = Festival::current())->count())
            $this->festival = $festival;
        else
            $this->festival = Festival::get()->first();

        \View::composer('public.*', function($view){
            $view->with([
                'festival'          => $this->festival,
                'festivals'         => $this->getFestivals(),
            ]);
        });
    }
*/
    public function index(SearchRequest $request, $festival_slug){
        return view('public.search');
    }
/*
    private function getFestivals(){
        return Festival::all()->sort(function($a, $b){
            return $this->festival->id === $b->id ? 1 : 0;
        });
    }
*/    
}
