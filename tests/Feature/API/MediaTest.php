<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_get_list_of_media()
    {
        $media = factory(\App\Media::class, 5)->create()->random();

        $this->get(route('api.media.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                $media->author
            ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_create_media()
    {
        $media = factory(\App\Media::class)->make();

        $media_to_post = [
            'en' => $media->translate('en')->toArray(),
            'de' => $media->translate('de')->toArray(),
        ];

        $this->post(route('api.media.store'), $media_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('media_translations', [
            'author' => $media->author,
            'title' => $media->title,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_media()
    {
        $old_media = factory(\App\Media::class)->create();

        $media = factory(\App\Media::class)->make();

        $media_to_post = [
            'en' => $media->translate('en')->toArray(),
            'de' => $media->translate('de')->toArray(),
        ];

        $this->post(route('api.media.update', $old_media->id), $media_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('media_translations', [
            'author' => $media->author,
            'title' => $media->title,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_media()
    {
        factory(\App\Media::class, 5)->create();

        $this->post(route('api.media.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('media', [
            'id' => 1
        ]);
    }
}
