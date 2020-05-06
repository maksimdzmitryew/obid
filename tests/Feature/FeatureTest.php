<?php

namespace Tests\Feature;

#use            Illuminate\Foundation\Testing\RefreshDatabase;
use                                    Tests\TestCase;
#use            Illuminate\Foundation\Testing\WithFaker;

class FeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomeer()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('version-app');
        $response->assertSee('initMap');
#        $response->assertSee('hideCookieDialog');
    }

    public function testSign()
    {
        $response = $this->get('/signin');
        $response->assertStatus(200);
/*
        $response->assertSee('version-app');
        $response->assertSee('initMap');
        $response->assertSee('hideCookieDialog');
*/
    }
}