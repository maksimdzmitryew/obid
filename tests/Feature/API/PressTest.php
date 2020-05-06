<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_get_presses_list()
    {
        $press = factory(\App\Press::class, 5)->create()->random();

        $this->get(route('api.presses.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                $press->name
            ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_create_a_press()
    {
        $press = factory(\App\Press::class)->make();

        $press_to_post = [
            'type' => $press->type,
            'festival_id' => $press->festival_id,
            'gallery_id' => $press->gallery_id,
            'en' => [
                'title' => $press->translate('en')->title,
                'description' => $press->translate('en')->description,
                'slug' => $press->translate('en')->slug,
                'volume' => $press->translate('en')->volume,
                'links' => [
                    'youtube' => $press->translate('en')->links->youtube,
                    'vimeo' => $press->translate('en')->links->vimeo,
                ],
            ],
            'de' => [
                'title' => $press->translate('de')->title,
                'description' => $press->translate('de')->description,
                'slug' => $press->translate('de')->slug,
                'volume' => $press->translate('de')->volume,
                'links' => [
                    'youtube' => $press->translate('en')->links->youtube,
                    'vimeo' => $press->translate('en')->links->vimeo,
                ],
            ],
        ];

        $this->post(route('api.presses.store'), $press_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('presses', [
            'id' => 1,
            'type' => $press->type,
            'gallery_id' => $press->gallery_id,
            'festival_id' => $press->festival_id,
        ])->assertDatabaseHas('press_translations', [
            'title' => $press->translate('en')->title,
            'description' => $press->translate('en')->description,
            'slug' => $press->translate('en')->slug,
            'volume' => $press->translate('en')->volume,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_a_press()
    {
        $old_press = factory(\App\Press::class)->create();

        $press = factory(\App\Press::class)->make();

        $press_to_post = [
            'type' => $press->type,
            'festival_id' => $press->festival_id,
            'gallery_id' => $press->gallery_id,
            'en' => [
                'title' => $press->translate('en')->title,
                'description' => $press->translate('en')->description,
                'slug' => $press->translate('en')->slug,
                'volume' => $press->translate('en')->volume,
                'links' => [
                    'youtube' => $press->translate('en')->links->youtube,
                    'vimeo' => $press->translate('en')->links->vimeo,
                ],
            ],
            'de' => [
                'title' => $press->translate('de')->title,
                'description' => $press->translate('de')->description,
                'slug' => $press->translate('de')->slug,
                'volume' => $press->translate('de')->volume,
                'links' => [
                    'youtube' => $press->translate('en')->links->youtube,
                    'vimeo' => $press->translate('en')->links->vimeo,
                ],
            ],
        ];

        $this->post(route('api.presses.update', $old_press->id), $press_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('presses', [
            'id' => 1,
            'type' => $press->type,
            'gallery_id' => $press->gallery_id,
            'festival_id' => $press->festival_id,
        ])->assertDatabaseHas('press_translations', [
            'title' => $press->translate('en')->title,
            'description' => $press->translate('en')->description,
            'slug' => $press->translate('en')->slug,
            'volume' => $press->translate('en')->volume,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_presses()
    {
        factory(\App\Press::class, 5)->create();

        $this->post(route('api.presses.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('presses', [
            'id' => 1
        ]);
    }
}
