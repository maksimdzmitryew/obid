<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CityTest extends TestCase
{
    /**
     * @test
     */
    public function an_authorized_user_can_create_a_city()
    {
        $city = factory(\App\City::class)->make();

        $city_to_post = [
            'timezone'      => $city->timezone,
            'en'            => $city->translations[0]->toArray(),
            'de'            => $city->translations[1]->toArray(),
        ];

        $this->post(route('api.cities.store'), $city_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('cities', [
            'id'            => 1
        ])->assertDatabaseHas('city_translations', [
            'name'          => $city->translate('en')->name,
        ])->assertDatabaseHas('city_translations', [
            'name'          => $city->translate('de')->name,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_a_city()
    {
        $old_city = factory(\App\City::class)->create();
        $city = factory(\App\City::class)->make();

        $city_to_post = [
            'timezone'      => $city->timezone,
            'en'            => $city->translations[0]->toArray(),
            'de'            => $city->translations[1]->toArray()
        ];

        $this->post(route('api.cities.update', $old_city->id), $city_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('cities', [
            'id'            => 1
        ])->assertDatabaseHas('city_translations', [
            'name'          => $city->translate('en')->name,
        ])->assertDatabaseHas('city_translations', [
            'name'          => $city->translate('de')->name,
        ]);

        $this->assertDatabaseMissing('city_translations', [
            'name'          => $old_city->translate('en')->name,
        ])->assertDatabaseMissing('city_translations', [
            'name'          => $old_city->translate('de')->name,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_cities()
    {
        factory(\App\City::class, 5)->create();

        $this->post(route('api.cities.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('cities', [
            'id' => 3
        ]);
    }
}
