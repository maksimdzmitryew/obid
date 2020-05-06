<?php

namespace App\Http\Controllers\API;

use App\Artist;
use App\Filters\ArtistFilters;
use App\Http\Requests\ArtistCreateRequest;
use App\Http\Requests\ArtistRequest;
use App\Http\Requests\ArtistUpdateRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArtistApiRequest;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public function index(ArtistApiRequest $request, ArtistFilters $filters)
    {
        if (isset($request->vocation_id) && $request->vocation_id){
            $vocation_id = $request->vocation_id;
            $artists = Artist::filter($filters)->whereHas('vocations',function($query) use ($vocation_id){
                $query->where('vocation_id','=',$vocation_id);
            });
        } else {
            $artists = Artist::filter($filters);
        }

        return response([
            'draw'            => $request->draw,
            'data'            => $artists->with('festivals')->get(),
            'recordsTotal'    => Artist::count(),
            'qty_filtered'    => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(ArtistCreateRequest $request)
    {

        $request->merge([
            'team_member' => !! $request->team_member,
            'board_member' => !! $request->board_member,
        ]);

        $artist = Artist::create($request->only('url', 'email', 'facebook', 'en', 'de'));
        $artist->processImages($request);
        //$artist->festivals()->sync($request->post('festivals'));
        #$artist->attachImage($request);

        $data = [];

        $festivals = $request->post('festivals') ?? collect();

        foreach($festivals as $festival){
            $data[] = [
                'artist_id' => $artist->id,
                'festival_id' => $festival['id'],
                'profession_id' => $festival['profession_id'] == '0' ? NULL : $festival['profession_id'],
                'team_member' => !! isset($festival['team_member']),
                'board_member' => !! isset($festival['board_member']),
                'order' => $festival['order'],
            ];
        }

        DB::table('festival_artist')->insert($data);

        $artist->vocations()->sync($request->vocation_ids);

        return response([
            'message' => trans('messages.artist_created')
        ], 200);
    }

    public function update(ArtistUpdateRequest $request, Artist $artist)
    {
        //dd($request->post('festivals'));

        $request->merge([
            'team_member' => !! $request->team_member,
            'board_member' => !! $request->board_member,
        ]);

        $artist->update($request->only('url', 'email', 'facebook', 'en', 'de'));

        //$artist->festivals()->sync($request->post('festivals'));
        #$artist->updateImage($request);
		$artist->processImages($request);

        $data = [];

        DB::table('festival_artist')->where([
            'artist_id' => $artist->id
        ])->delete();

        $festivals = $request->post('festivals') ?? collect();

        foreach($festivals as $festival){
            $data[] = [
                'artist_id' => $artist->id,
                'festival_id' => $festival['id'],
                'profession_id' => $festival['profession_id'] == '0' ? NULL : $festival['profession_id'],
                'team_member' => !! isset($festival['team_member']),
                'board_member' => !! isset($festival['board_member']),
                'order' => $festival['order'],
            ];
        }

        DB::table('festival_artist')->insert($data);

        $artist->vocations()->sync($request->vocation_ids);

        return response([
            'message' => trans('messages.artist_updated')
        ], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Artist::destroy($request->ids);

        $number = count($request->ids);

        return response([
            'message' => trans_choice('messages.artists_deleted', $number, ['number' => $number])
        ], 200);
    }
}
