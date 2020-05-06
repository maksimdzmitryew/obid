<?php

namespace App\Http\Controllers\Admin;

use App\Artist;
use App\Festival;
use App\Profession;
use App\Vocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public function index()
    {
        return view('admin.artists.list', [
            'dates' => Artist::getTimestampDates(),
            'festivals' => Festival::all()->sortByDesc('year'),
            'vocations' => Vocation::all()->sortBy('name'),
        ]);
    }

    public function form(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ]);

        $artist = Artist::findOrNew($request->id);

        $festivals = collect();

        if($artist->id){
            $festivals = DB::table('festival_artist as fa')
                ->select('fa.*', 'f.id', 'ft.name')
                ->join('festivals as f', 'fa.festival_id', '=', 'f.id')
                ->join('festival_translations as ft', 'f.id', '=', 'ft.festival_id')
                ->where([
                    'fa.artist_id' => $artist->id,
                    'ft.locale' => app()->getLocale(),
                ])
                ->groupBy('f.id')
                ->get();
        }

        //dd($festivals);

        return view('admin.artists.form', [
            'artist' => $artist,
            'artist_festivals' => $artist->festivals,
            'festivals' => $festivals,
            'vocations' => Vocation::all()->sortBy('name'),
            'professions' => Profession::all(),
        ]);
    }
}
