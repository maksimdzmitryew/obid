<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlideTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_store_slide()
    {
        $image = factory(\App\File::class)->create(['type' => 'image']);
        $slide = factory(\App\Slide::class)->make();

        $slide_to_post = [
            'slider_id' => $slide->slider_id,
            'position'  => $slide->position,
            'image_id' => $image->id,
            'en' => $slide->translate('en')->toArray(),
            'de' => $slide->translate('de')->toArray()
        ];

        $this->post(route('api.slides.store'), $slide_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            'slider_id' => $slide->slider_id,
            'position' => $slide->position,
        ])->assertDatabaseHas('files', [
            'filable_type' => 'App\Slide',
            'filable_id' => 1
        ]);

        $image->delete();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_slide()
    {
        $image = factory(\App\File::class)->create(['type' => 'image']);
        $old_slide = factory(\App\Slide::class)->create()->attachImage($image->id);

        $slide = factory(\App\Slide::class)->make();
        $new_image = factory(\App\File::class)->create(['type' => 'image']);

        $slide_to_post = [
            'slider_id' => $slide->slider_id,
            'position'  => $slide->position,
            'image_id' => $new_image->id,
            'en' => $slide->translate('en')->toArray(),
            'de' => $slide->translate('de')->toArray()
        ];

        $this->post(route('api.slides.update', $old_slide->id), $slide_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            'slider_id' => $slide->slider_id,
            'position' => $slide->position,
        ]);

        $this->assertDatabaseHas('slide_translations', [
            'dates' => $slide->translate('en')->dates,
            'title' => $slide->translate('en')->title,
            'description' => $slide->translate('en')->description,
            'button_text' => $slide->translate('en')->button_text,
            'button_url' => $slide->translate('en')->button_url,
        ])->assertDatabaseHas('slide_translations', [
            'dates' => $slide->translate('de')->dates,
            'title' => $slide->translate('de')->title,
            'description' => $slide->translate('de')->description,
            'button_text' => $slide->translate('de')->button_text,
            'button_url' => $slide->translate('de')->button_url,
        ])->assertDatabaseHas('files', [
            'filable_type' => 'App\Slide',
            'filable_id' => $old_slide->id
        ]);

        $image->delete();
        $new_image->delete();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_slides()
    {
        factory(\App\Slide::class, 5)->create();

        $this->post(route('api.slides.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('slides', [
            'id' => 1
        ]);
    }
}
