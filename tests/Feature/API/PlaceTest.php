<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_create_a_place()
    {
        $place = factory(\App\Place::class)->make();

        $place_to_post = [
            'city_id' => $place->city_id,
            'en' => $place->translations[0]->toArray(),
            'de' => $place->translations[1]->toArray()
        ];

        $this->post(route('api.places.store'), $place_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('places', [
            'city_id' => $place->city_id
        ])->assertDatabaseHas('place_translations', [
            'name' => $place->translate('en')->name,
        ])->assertDatabaseHas('place_translations', [
            'name' => $place->translate('de')->name,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_a_place()
    {
        $old_place = factory(\App\Place::class)->create();
        $place = factory(\App\Place::class)->make();

        $place_to_post = [
            'city_id' => $place->city_id,
            'en' => $place->translations[0]->toArray(),
            'de' => $place->translations[1]->toArray()
        ];

        $this->post(route('api.places.update', $old_place->id), $place_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('places', [
            'city_id' => $place->city_id
        ])->assertDatabaseHas('place_translations', [
            'name' => $place->translate('en')->name,
        ])->assertDatabaseHas('place_translations', [
            'name' => $place->translate('de')->name,
        ]);

        $this->assertDatabaseMissing('places', [
            'city_id' => $old_place->city_id
        ])->assertDatabaseMissing('place_translations', [
            'name' => $old_place->translate('en')->name,
        ])->assertDatabaseMissing('place_translations', [
            'name' => $old_place->translate('de')->name,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_places()
    {
        factory(\App\Place::class, 5)->create();

        $this->post(route('api.places.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('places', [
            'id' => 1
        ]);
    }
}
