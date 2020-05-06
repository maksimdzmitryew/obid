<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FestivalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_create_festival()
    {
        $festival = factory(\App\Festival::class)->make();

        $festival_to_post = [
            'active' => $festival->active,
            'en' => $festival->translate('en')->toArray(),
            'de' => $festival->translate('de')->toArray(),
        ];

        $this->post(route('api.festivals.store'), $festival_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('festivals', ['id' => '1'])
            ->assertDatabaseHas('festival_translations', [
                'name' => $festival->translate('en')->name,
            ])
            ->assertDatabaseHas('festival_translations', [
                'name' => $festival->translate('de')->name,
            ]);
    }

    /**
     * @test
     */
    public function authorized_user_can_update_festival()
    {
        $old_festival = factory(\App\Festival::class)->create();
        $festival = factory(\App\Festival::class)->make(['active' => 1]);

        $festival_to_post = [
            'active' => $festival->active,
            'en' => $festival->translate('en')->toArray(),
            'de' => $festival->translate('de')->toArray(),
        ];

        $this->post(route('api.festivals.update', $old_festival->id), $festival_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('festivals', [
                'active' => $festival->active,
            ])
            ->assertDatabaseHas('festival_translations', [
                'name' => $festival->translate('en')->name,
            ])
            ->assertDatabaseHas('festival_translations', [
                'name' => $festival->translate('de')->name,
            ]);
    }

    /**
     * @test
     */
    public function authorized_user_can_delete_festival()
    {
        factory(\App\Festival::class, 5)->create();

        $this->post(route('api.festivals.delete'), [
            'ids' => [1, 3]
        ]);

        $this->assertDatabaseMissing('festivals', [
            'id' => 1
        ]);
    }
}
