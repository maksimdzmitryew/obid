<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    /**
     * @test
     */
    public function an_authorized_user_can_create_a_category()
    {
        $category = factory(\App\Category::class)->make();

        $category_to_post = [
            'type'          => $category->type,
            'en'            => $category->translations[0]->toArray(),
            'de'            => $category->translations[1]->toArray(),
        ];

        $this->post(route('api.categories.store'), $category_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'type'          => $category->type
        ])->assertDatabaseHas('category_translations', [
            'name'          => $category->translate('en')->name,
            'slug'          => $category->translate('en')->slug,
        ])->assertDatabaseHas('category_translations', [
            'name'          => $category->translate('de')->name,
            'slug'          => $category->translate('de')->slug,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_a_category()
    {
        $old_category       = factory(\App\Category::class)->create();
        $category           = factory(\App\Category::class)->make(['type' => 'events']);

        $category_to_post = [
            'type'          => $category->type,
            'en'            => $category->translations[0]->toArray(),
            'de'            => $category->translations[1]->toArray()
        ];

        $this->post(route('api.categories.update', $old_category->id), $category_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'type'          => $category->type
        ])->assertDatabaseHas('category_translations', [
            'name'          => $category->translate('en')->name,
            'slug'          => $category->translate('en')->slug,
        ])->assertDatabaseHas('category_translations', [
            'name'          => $category->translate('de')->name,
            'slug'          => $category->translate('de')->slug,
        ]);

        $this->assertDatabaseMissing('categories', [
            'type'          => $old_category->type
        ])->assertDatabaseMissing('category_translations', [
            'name'          => $old_category->translate('en')->name,
            'slug'          => $old_category->translate('en')->slug,
        ])->assertDatabaseMissing('category_translations', [
            'name'          => $old_category->translate('de')->name,
            'slug'          => $old_category->translate('de')->slug,
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_categories()
    {
        factory(\App\Category::class, 5)->create();

        $this->post(route('api.categories.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('categories', [
            'id' => 3
        ]);
    }
}
