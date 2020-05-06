<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_create_a_partner()
    {
        $partner = factory(\App\Partner::class)->make();
        $category = factory(\App\Category::class)->create();
        $image = factory(\App\File::class)->create(['type' => 'image']);

        $partner_to_post = [
            'url' => $partner->url,
            'category_id' => $category->id,
            'image_id' => $image->id,
            'promoting' => $partner->promoting
        ];

        $this->post(route('api.partners.store'), $partner_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('partners', [
            'url' => $partner->url,
            'promoting' => !! $partner->promoting,
            'category_id' => $category->id,
        ])
        ->assertDatabaseHas('files', [
            'filable_id' => 1,
            'filable_type' => 'App\Partner'
        ]);

        $image->delete();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_a_partner()
    {   
        $old_image = factory(\App\File::class)->create(['type' => 'image']);
        $old_partner = factory(\App\Partner::class)->create()->attachImage($old_image->id);
        
        $partner = factory(\App\Partner::class)->make();
        $category = factory(\App\Category::class)->create();
        $image = factory(\App\File::class)->create(['type' => 'image']);

        $partner_to_post = [
            'url' => $partner->url,
            'category_id' => $category->id,
            'image_id' => $image->id,
            'promoting' => $partner->promoting
        ];

        $this->post(route('api.partners.update', $old_partner->id), $partner_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('partners', [
            'url' => $partner->url,
            'promoting' => !! $partner->promoting,
            'category_id' => $category->id,
        ])
        ->assertDatabaseHas('files', [
            'filable_id' => 1,
            'filable_type' => 'App\Partner'
        ]);

        $image->delete();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_partners()
    {
        factory(\App\Partner::class, 5)->create();

        $this->post(route('api.partners.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('partners', [
            'id' => 1
        ]);
    }
}
