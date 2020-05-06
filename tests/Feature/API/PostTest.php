<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_create_post()
    {
        $post = factory(\App\Post::class)->make();
        $category = factory(\App\Category::class)->create(['type' => 'news']);
        $festival = factory(\App\Festival::class)->create();

        $post_to_post = [
            'category_id' => $category->id,
            'festival_id' => $festival->id,
            'en' => $post->translate('en')->toArray(),
            'de' => $post->translate('de')->toArray(),
        ];

        $this->post(route('api.news.store'), $post_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('posts',[
            'category_id' => $category->id,
            'festival_id' => $festival->id,
        ])
        ->assertDatabaseHas('post_translations', [
            'slug' => $post->translate('en')->slug,
            'title' => $post->translate('en')->title,
            'excerpt' => $post->translate('en')->excerpt,
            'body' => $post->translate('en')->body,
            'meta_title' => $post->translate('en')->meta_title,
            'meta_description' => $post->translate('en')->meta_description,
            'meta_keywords' => $post->translate('en')->meta_keywords,
        ])
        ->assertDatabaseHas('post_translations', [
            'slug' => $post->translate('de')->slug,
            'title' => $post->translate('de')->title,
            'excerpt' => $post->translate('de')->excerpt,
            'body' => $post->translate('de')->body,
            'meta_title' => $post->translate('de')->meta_title,
            'meta_description' => $post->translate('de')->meta_description,
            'meta_keywords' => $post->translate('de')->meta_keywords,
        ]);
    }

    /**
     * @test
     */
    public function user_can_update_post()
    {
        $old_post = factory(\App\Post::class)->create();
        $category = factory(\App\Category::class)->create(['type' => 'news']);
        $festival = factory(\App\Festival::class)->create();

        $post = factory(\App\Post::class)->make();

        $post_to_post = [
            'category_id' => $category->id,
            'festival_id' => $festival->id,
            'en' => $post->translate('en')->toArray(),
            'de' => $post->translate('de')->toArray(),
        ];

        $this->post(route('api.news.update', $old_post->id), $post_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('posts',[
            'category_id' => $category->id,
            'festival_id' => $festival->id,
        ])
        ->assertDatabaseHas('post_translations', [
            'slug' => $post->translate('en')->slug,
            'title' => $post->translate('en')->title,
            'excerpt' => $post->translate('en')->excerpt,
            'body' => $post->translate('en')->body,
            'meta_title' => $post->translate('en')->meta_title,
            'meta_description' => $post->translate('en')->meta_description,
            'meta_keywords' => $post->translate('en')->meta_keywords,
        ])
        ->assertDatabaseHas('post_translations', [
            'slug' => $post->translate('de')->slug,
            'title' => $post->translate('de')->title,
            'excerpt' => $post->translate('de')->excerpt,
            'body' => $post->translate('de')->body,
            'meta_title' => $post->translate('de')->meta_title,
            'meta_description' => $post->translate('de')->meta_description,
            'meta_keywords' => $post->translate('de')->meta_keywords,
        ]);
    }

    /**
     * @test
     */
    public function user_can_delete_events()
    {
        factory(\App\Post::class, 5)->create();

        $this->post(route('api.news.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'id' => 1,
        ]);
    }
}
