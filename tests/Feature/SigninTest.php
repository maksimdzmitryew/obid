<?php

namespace Tests\Feature;

#use            Illuminate\Foundation\Testing\RefreshDatabase;
use                                    Tests\TestCase;
#use            Illuminate\Foundation\Testing\WithFaker;

use            Illuminate\Foundation\Testing\WithoutMiddleware;


class SigninTest extends TestCase
{
	use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSignin()
    {
/*
        $response = $this->get('/signin');
dd($response);
        $response->assertStatus(200);
        $response->assertSee('version-app');
        $response->assertSee('initMap');
        $response->assertSee('hideCookieDialog');
*/
    }
}