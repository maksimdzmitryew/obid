<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_autorized_user_can_create_a_book()
    {
        $book = factory(\App\Book::class)->make();
        $book_to_post = [
            'url' => $book->url,
            'api_code' => $book->api_code,
            'festival_id' => $book->festival_id,
            'en' => $book->translate('en')->toArray(),
            'de' => $book->translate('de')->toArray(),
        ];

        $this->post(route('api.books.store'), $book_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('book_translations', [
            'name' => $book->translate('en')->name,
            'slug' => $book->translate('en')->slug,
            'excerpt' => $book->translate('en')->excerpt,
            'description' => $book->translate('en')->description,
            'excerpt' => $book->translate('en')->excerpt,
            'meta_title' => $book->translate('en')->meta_title,
            'meta_keywords' => $book->translate('en')->meta_keywords,
            'meta_description' => $book->translate('en')->meta_description,

        ])->assertDatabaseHas('book_translations', [
            'name' => $book->translate('de')->name,
            'slug' => $book->translate('de')->slug,
            'excerpt' => $book->translate('de')->excerpt,
            'description' => $book->translate('de')->description,
            'excerpt' => $book->translate('de')->excerpt,
            'meta_title' => $book->translate('de')->meta_title,
            'meta_keywords' => $book->translate('de')->meta_keywords,
            'meta_description' => $book->translate('de')->meta_description,
        ])->assertDatabaseHas('books', [
            'url' => $book->url,
            'festival_id' => $book->festival_id,
            'api_code' => $book->api_code
        ]);
    }

    /**
     * @test
     */
    public function an_autorized_user_can_update_a_book()
    {
        $old_book = factory(\App\Book::class)->create();
        $book = factory(\App\Book::class)->make();
        $book_to_post = [
            'url' => $book->url,
            'api_code' => $book->api_code,
            'festival_id' => $book->festival_id,
            'en' => $book->translate('en')->toArray(),
            'de' => $book->translate('de')->toArray(),
        ];

        $this->post(route('api.books.update', $old_book->id), $book_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('book_translations', [
            'name' => $book->translate('en')->name,
            'slug' => $book->translate('en')->slug,
            'excerpt' => $book->translate('en')->excerpt,
            'description' => $book->translate('en')->description,
            'excerpt' => $book->translate('en')->excerpt,
            'meta_title' => $book->translate('en')->meta_title,
            'meta_keywords' => $book->translate('en')->meta_keywords,
            'meta_description' => $book->translate('en')->meta_description,

        ])->assertDatabaseHas('book_translations', [
            'name' => $book->translate('de')->name,
            'slug' => $book->translate('de')->slug,
            'excerpt' => $book->translate('de')->excerpt,
            'description' => $book->translate('de')->description,
            'excerpt' => $book->translate('de')->excerpt,
            'meta_title' => $book->translate('de')->meta_title,
            'meta_keywords' => $book->translate('de')->meta_keywords,
            'meta_description' => $book->translate('de')->meta_description,
        ])->assertDatabaseHas('books', [
            'url' => $book->url,
            'festival_id' => $book->festival_id,
            'api_code' => $book->api_code
        ]);
    }

    /**
     * @test
     */
    public function artists_can_be_assigned_to_a_book()
    {
        $artists = factory(\App\Artist::class, 5)->create();
        $book = factory(\App\Book::class)->make();

        $book_to_post = [
            'url' => $book->url,
            'api_code' => $book->api_code,
            'festival_id' => $book->festival_id,
            'en' => $book->translate('en')->toArray(),
            'de' => $book->translate('de')->toArray(),
            'author_ids' => $artists->pluck('id')->toArray()
        ];

        $this->post(route('api.books.store'), $book_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('artist_book', [
            'artist_id' => $artists->first()->id,
            'book_id' => 1
        ]);

        $artists = factory(\App\Artist::class, 5)->create();
        $new_book = factory(\App\Book::class)->create();

        $book_to_post = [
            'url' => $new_book->url,
            'api_code' => $new_book->api_code,
            'festival_id' => $new_book->festival_id,
            'en' => $new_book->translate('en')->toArray(),
            'de' => $new_book->translate('de')->toArray(),
            'author_ids' => $artists->pluck('id')->toArray()
        ];

        $this->post(route('api.books.update', $new_book->id), $book_to_post)
            ->assertStatus(200);

        $this->assertDatabaseHas('artist_book', [
            'artist_id' => $artists->first()->id,
            'book_id' => $new_book->id
        ]);
    }

    /**
     * @test
     */
    public function an_autorized_user_can_delete_books()
    {
        factory(\App\Book::class, 5)->create();

        $this->post(route('api.books.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('books', ['id' => 3]);
    }
}