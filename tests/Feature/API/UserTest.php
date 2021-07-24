<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
#    use RefreshDatabase;


    public function _signinAsAVirtualUser()
    {
        $o_user = new User([
            'name' => 'virtual_user'
        ]);

        $o_user->id = 1;

        $this->be($o_user);
    }

    /**
     * @test
     */
    public function AnyAuthorisedUserCanViewUsersList()
    {
        self::_signinAsAVirtualUser();

        // override factory's password
        $s_password = str_random(rand(6,10));
        $s_password_crypt = bcrypt($s_password);

        $o_user = factory('App\User')->create(['password' => $s_password_crypt]);

        $this->get(route('api.user.index'))
            ->assertJsonFragment([
                'first_name' => $o_user->first_name,
                'email' => $o_user->email,
#                'password' => $s_password_crypt,
            ])
            ->assertStatus(200);
    }

    /**
     * @test
     * /
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
     * /
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
     * /
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
     * /
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
    */
}
