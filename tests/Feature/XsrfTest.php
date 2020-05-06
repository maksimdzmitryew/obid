<?php

namespace Tests\Feature;

use                                    Tests\TestCase;
#use            Illuminate\Foundation\Testing\WithFaker;

class XsrfTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenRoute()
    {
        $response = $this->get('/refresh-csrf');
        $response->assertStatus(200);
        $response->assertCookie('XSRF-TOKEN');
    }
}