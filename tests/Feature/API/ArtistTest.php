<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ArtistTest extends TestCase
{

    /**
     * @test
     */
    public function an_authorized_user_can_create_an_artist()
    {
#echo env('DB_DATABASE', storage_path('database.sqlite'))."\n";
#echo env('DB_DATABASE', database_path('database.sqlite'))."\n";
#die();
        $artist = factory(\App\Artist::class)->make();
        $artist_to_post = [
            'url'           => $artist->url,
            'email'         => $artist->email,
            'facebook'      => $artist->facebook,
            #'team_member' => 1,
            #'board_member' => 0,
            'en'            => $artist->translations[0]->toArray(),
            'de'            => $artist->translations[1]->toArray()
        ];

        $this->post(route('api.artists.store'), $artist_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('artist_translations', [
            'name'          => $artist->translate('en')->name,
            'profession'    => $artist->translate('en')->profession,
            'description'   => $artist->translate('en')->description,
        ])->assertDatabaseHas('artist_translations', [
            'name'          => $artist->translate('de')->name,
            'profession'    => $artist->translate('de')->profession,
            'description'   => $artist->translate('de')->description,
        ])->assertDatabaseHas('artists', [
            'url'           => $artist->url,
            'email'         => $artist->email,
            'facebook'      => $artist->facebook,
            #'team_member' => 1,
            #'board_member' => 0,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_an_artist()
    {
        $old_artist = factory(\App\Artist::class)->create();#['team_member' => 1]);

        $artist = factory(\App\Artist::class)->make(['email' => 'no@spam.com']);

        $artist_to_post = [
            'url'           => $artist->url,
            'email'         => $artist->email,
            'facebook'      => $artist->facebook,
            #'team_member' => 0,
            #'board_member' => 1,
            'en'            => $artist->translations[0]->toArray(),
            'de'            => $artist->translations[1]->toArray()
        ];

        $this->post(route('api.artists.update', $old_artist->id), $artist_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('artist_translations', [
            'name'          => $artist->translate('en')->name,
            'profession'    => $artist->translate('en')->profession,
            'description'   => $artist->translate('en')->description,
        ])->assertDatabaseHas('artist_translations', [
            'name'          => $artist->translate('de')->name,
            'profession'    => $artist->translate('de')->profession,
            'description'   => $artist->translate('de')->description,
        ])->assertDatabaseHas('artists', [
            'url'           => $artist->url,
            'email'         => $artist->email,
            'facebook'      => $artist->facebook,
            #'team_member' => 0,
            #'board_member' => 1,
        ]);

        $this->assertDatabaseMissing('artist_translations', [
            'name'          => $old_artist->translate('en')->name,
            'profession'    => $old_artist->translate('en')->profession,
            'description'   => $old_artist->translate('en')->description,
        ])->assertDatabaseMissing('artist_translations', [
            'name'          => $old_artist->translate('de')->name,
            'profession'    => $old_artist->translate('de')->profession,
            'description'   => $old_artist->translate('de')->description,
        ])->assertDatabaseMissing('artists', [
            'url'           => $old_artist->url,
            'email'         => $old_artist->email,
            'facebook'      => $old_artist->facebook,
            #'team_member' => 1,
            #'board_member' => 0,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_artists()
    {
        factory(\App\Artist::class, 5)->create();

        $this->post(route('api.artists.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('artists', [
            'id' => 3
        ]);
    }
}
