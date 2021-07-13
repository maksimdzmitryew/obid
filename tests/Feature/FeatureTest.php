<?php

namespace Tests\Feature;

use                                    Tests\TestCase;

class FeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}