<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
#use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
#    use RefreshDatabase;


    /**
     * sign in to the system as a user that is not stored in DB
     *
     * @return void
     */
    private function _signinAsVirtualUser() : void
    {
        $o_user = new User([
            'name' => 'virtual_user'
        ]);

        $o_user->id = 1;

        $this->be($o_user);
    }

    /**
     * sign in to the system as a user that is not stored in DB
     *
     * @param   String          plain text password
     *
     * @return  String          encrypted password
     */
    private function _getPasswordEncrypted($s_password) : String
    {
        return bcrypt($s_password);
    }

    /**
     * sign in to the system as a user that is not stored in DB
     *
     * @return  Object           user data
     */
    private function _createUserRecord() : Object
    {
        // override factory's password
        $s_password = str_random(rand(6,10));
        $s_password_crypt = self::_getPasswordEncrypted($s_password);

        $o_user = factory('App\User')->create(['password' => $s_password_crypt]);
        return $o_user;
    }

    /**
     * any authorised user can view users list with correct structure and password is not revealed
     *
     * @return void
     * @test
     */
    public function AnyAuthorisedUserCanViewUsersListWithCorrectStructureAndPasswordIsNotRevealed() : void
    {
        self::_signinAsVirtualUser();
        $o_user = self::_createUserRecord();
        $s_password_crypt = self::_getPasswordEncrypted($o_user->password);

        $this
            ->get(route('api.user.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' =>
                    [
                        ['email', 'published', 'first_name', 'id', 'last_name', 'roles', ],
                    ],
                    'draw',
                    'recordsFiltered',
                    'recordsTotal',
            ])
            ->assertJsonMissing([
                'password' => $s_password_crypt,
            ])
            ;
    }

    /**
     * users list can be filtered descending by id column
     *
     * @return void
     * @test
     */
    public function UsersListCanBeFilteredDescendingByIdColumn() : void
    {
        self::_signinAsVirtualUser();
        $o_user = self::_createUserRecord();
        $s_password_crypt = self::_getPasswordEncrypted($o_user->password);

        $a_order[0] = [
            'column' => '2',
            'dir' => 'desc',
        ];

        $parameters = [
                        'length' => 1,
                        'order' => $a_order,
                    ];
        $cookies = [];
        $files = [];
        $server = [];
        $content = null;

        $this
            ->get(route('api.user.index', $parameters))
            ->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => $o_user->first_name,
                'email' => $o_user->email,
            ])
            ->assertJsonMissing([
                'password' => $s_password_crypt,
            ])
            ;

#        $s_res = $this->call('GET', route('api.user.index'), $parameters, $cookies, $files, $server, $content);
#        $s_res = $this->json('GET', route('api.user.index'), $parameters);
    }

    /**
     * @ test
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
