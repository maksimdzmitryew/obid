<?php

namespace Tests\Feature;

use                                       Tests\TestCase;
use               Illuminate\Foundation\Testing\WithoutMiddleware;

class FeatureTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuest()
    {
        /**
         *  errors will be written to stdout instead of to page contents
         */
        $this->withoutExceptionHandling();

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPower()
    {
        /**
         *  errors will be written to stdout instead of to page contents
         */
        $this->withoutExceptionHandling();

        $response = $this->get('/signin');
        $response->assertStatus(200);
    }
}
