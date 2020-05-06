<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class EventTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_create_event()
    {
        $director           = factory(\App\Artist::class)->create();
        $artist             = factory(\App\Artist::class)->create();
        $producer           = factory(\App\Artist::class)->create();
        $executive_producer = factory(\App\Artist::class)->create();

        $holdings           = factory(\App\EventHolding::class, 5)->make(['event_id' => null]);

        $festival           = factory(\App\Festival::class)->create();
        $category           = factory(\App\Category::class)->create(['type' => 'events']);

        $event = factory(\App\Event::class)->make([
            'category_id'   => null,
            'festival_id'   => null,
            'gallery_id'    => null,
        ]);

        $event_to_post = [
            'category_id'   => $category->id,
            'festival_id'   => $festival->id,
            'gallery_id'    => null,
            'promoting'     => $event->promoting,
            'en'            => $event->translate('en')->toArray(),
            'de'            => $event->translate('de')->toArray(),
            'artists'       => [
                                    'directors' => [
                                        $director->id,
                                    ],
                                    'artists' => [
                                        $artist->id,
                                    ],
                                    'producers' => [
                                        $producer->id,
                                    ],
                                    'executive_producers' => [
                                        $executive_producer->id,
                                    ],
                                ],
            'holdings'      => $holdings->toArray(),
        ];

        $this->post(route('api.events.store', $event_to_post))
            ->assertStatus(200);

        $this->assertDatabaseHas('event_translations', [
                'slug'      => $event->slug,
                'title'     => $event->title,
                'description' => $event->description,
                'body'      => $event->body,
            ])
            ->assertDatabaseHas('event_holdings', [
                'date_from' => $holdings->first()->date_from->toDateTimeString(),
                'event_id'  => 1,
                'place_id'  => $holdings->first()->place_id,
                'city_id'   => $holdings->first()->place->city_id,
                'ticket_url' => $holdings->first()->ticket_url,
            ])
            ->assertDatabaseHas('artist_event', [
                'artist_id' => $executive_producer->id,
                'event_id'  => 1,
                'role'      => 'executive_producer'
            ]);
    }

    /**
     * @test
     */
    public function user_can_update_event()
    {
        $event              = factory(\App\Event::class)->create();
        $holdings           = factory(\App\EventHolding::class, 5)->create(['event_id' => $event->id]); 
        $director           = factory(\App\Artist::class)->create();
        $producer           = factory(\App\Artist::class)->create();
        $artist             = factory(\App\Artist::class)->create();
        $executive_producer = factory(\App\Artist::class)->create();

        $event->artists()->syncWithoutDetaching([
            $director->id   => ['role' => 'director'],
            $producer->id   => ['role' => 'producer'],
            $artist->id     => ['role' => 'artist'],
            $executive_producer->id => ['role' => 'executive_producer'],
        ]);

        $another_event      = factory(\App\Event::class)->make();
        $another_holdings   = factory(\App\EventHolding::class, 5)->make(['event_id' => null]);
        $another_director   = factory(\App\Artist::class)->create();
        $another_producer   = factory(\App\Artist::class)->create();
        $another_artist     = factory(\App\Artist::class)->create();
        $another_executive_producer = factory(\App\Artist::class)->create();
        $another_category   = factory(\App\Category::class)->create(['type' => 'events']);

        $another_festival   = factory(\App\Festival::class)->create();

        $event_to_post = [
            'category_id'   => $another_category->id,
            'festival_id'   => $another_festival->id,
            'gallery_id'    => null,
            'promoting'     => $another_event->promoting,
            'en'            => $another_event->translate('en')->toArray(),
            'de'            => $another_event->translate('de')->toArray(),
            'artists'       => [
                                    'directors' => [
                                        $another_director->id,
                                    ],
                                    'artists' => [
                                        $another_artist->id,
                                    ],
                                    'producers' => [
                                        $another_producer->id,
                                    ],
                                    'executive_producers' => [
                                        $another_executive_producer->id,
                                    ],
                                ],
            'holdings'      => $another_holdings->toArray(),
        ];

        $another_holding    = $another_holdings->first();

        $this->post(route('api.events.update', $event->id), $event_to_post);

        $this->assertDatabaseHas('event_translations', [
                'slug'      => $another_event->translate('en')->slug,
                'title'     => $another_event->translate('en')->title,
                'description' => $another_event->translate('en')->description,
                'body'      => $another_event->translate('en')->body])
            ->assertDatabaseHas('event_holdings', [
                'date_from' => $another_holding->date_from,
                'event_id'  => $event->id,
                'place_id'  => $another_holding->place_id,
                'ticket_url' => $another_holding->ticket_url,
                'city_id'   => $another_holding->place->city_id
            ])
            ->assertDatabaseHas('artist_event', [
                'artist_id' => $another_director->id,
                'event_id'  => $event->id,
                'role'      => 'director'
            ])
            ->assertDatabaseHas('events', [
                'festival_id' => $another_festival->id,
                'category_id' => $another_category->id
            ]);
    }

    /**
     * @test
     */
    public function user_can_delete_events()
    {
        factory(\App\Event::class, 5)->create();

        $this->post(route('api.events.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('events', [
            'id' => 1,
        ]);
    }
}