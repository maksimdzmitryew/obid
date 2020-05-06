<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authorized_user_can_get_users_list()
    {
        $user = factory('App\User')->create();

        $this->get(route('api.users.index'))
            ->assertJsonFragment([
                'name' => $user->name,
                'email' => $user->email
            ])
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function authorized_user_can_create_user()
    {
        $this->post(route('api.users.store'), [
                'name' => 'John Doe',
                'email' => 'JohnDoe@example.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
                'name' =>'John Doe',
                'email' => 'JohnDoe@example.com',
        ]);
    }

    /**
     * @test
     */
    public function authorized_user_can_filter_users_by_name()
    {
        $johnDoe = factory('App\User')->create(['name' => 'John Doe']);
        $notJohnDoe = factory('App\User', 40)->create(['name' => 'Jane Doe']);

        $this->get(route('api.users.index', [
            'filters' => [
                'name' => 'John Doe',
                'email' => '',
                'bad' => 'thing'
            ],
            'columns' => [
                [
                    'data' => 'id',
                    'name' => '',
                    'searchable' => true,
                    'orderable' => true,
                    'search' => [
                        'value' => '',
                        'regex' => false,
                    ],
                ],
                [
                    'data' => 'name',
                    'name' => '',
                    'searchable' => true,
                    'orderable' => true,
                    'search' => [
                        'value' => '',
                        'regex' => false,
                    ],
                ],
                [
                    'data' => 'email',
                    'name' => '',
                    'searchable' => true,
                    'orderable' => true,
                    'search' => [
                        'value' => '',
                        'regex' => false,
                    ],
                ],
            ],
            "order" => [
                0 => [
                    "column" => "0",
                    "dir" => "asc"
                ]
            ],
            "start" => "0",
            "length" => "20",
            "search" => [
                "value" => null,
                "regex" => "false"
            ]
        ]))
        ->assertJsonFragment([
            'name' => $johnDoe->name,
            'email' => $johnDoe->email
        ])->assertJsonMissing([
            'name' => $notJohnDoe->first()->name,
            'email' => $notJohnDoe->first()->name,
        ]);
    }

    /**
     * @test
     */
    public function authorized_user_can_edit_user()
    {
        $user = factory('App\User')->create();

        $this->get(route('admin.users.form', $user))
            ->assertSee($user->name);

        $this->post(route('api.users.update', $user), [
                'name' => 'John Doe',
                'email' => 'JohnDoe@example.com',
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'JohnDoe@example.com',
        ]);
    }

    /**
     * @test
     */
    public function authorized_user_can_delete_user()
    {
        $user = factory('App\User')->create();

        $this->post(route('api.users.delete', [
                'ids' => [1]
            ]))
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}
