<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GalleryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_get_galleries_list()
    {
        $gallery = factory(\App\Gallery::class, 5)->create()->random();

        $this->get(route('api.galleries.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                $gallery->name
            ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_create_a_gallery()
    {
        $gallery = factory(\App\Gallery::class)->make();
        $images = factory(\App\File::class, 4)->create(['type' => 'image'])
            ->shuffle()->map->id->toArray();

        $gallery_to_post = [
            'name' => $gallery->name,
            'image_ids' => $images
        ];

        $this->post(route('api.galleries.store'), $gallery_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('galleries', [
            'name' => $gallery->name,
        ]);

        $this->assertDatabaseHas('files', [
            'filable_id' => 1,
            'filable_type' => 'App\Gallery',
        ]);
        
        \App\File::destroy($images);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_a_gallery()
    {
        $old_gallery = factory(\App\Gallery::class)->create();
        $old_images = factory(\App\File::class, 4)
            ->create(['type' => 'image'])
            ->each(function ($image) use ($old_gallery) {
                $image->filable()->associate($old_gallery);
                $image->type = 'gallery_item';
                $image->save();
            });

        $gallery = factory(\App\Gallery::class)->make();
        $images = factory(\App\File::class, 4)->create(['type' => 'image'])
            ->shuffle()->map->id->toArray();

        $gallery_to_post = [
            'name' => $gallery->name,
            'image_ids' => $images
        ];

        $this->post(route('api.galleries.update', $old_gallery->id), $gallery_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('galleries', [
            'name' => $gallery->name,
        ]);

        $this->assertDatabaseHas('files', [
            'id' => $images[0],
            'filable_id' => 1,
            'filable_type' => 'App\Gallery',
        ])
        ->assertDatabaseMissing('files', [
            'id' => $old_images[0]
        ]);
        
        \App\File::destroy($images);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_galleries()
    {
        factory(\App\Gallery::class, 5)->create();

        $this->post(route('api.galleries.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('galleries', [
            'id' => 1
        ]);
    }
}
