<?php

declare(strict_types=1);

namespace Tests\Feature;

use                                       Tests\TestCase;
use               Illuminate\Foundation\Testing\WithoutMiddleware;

class FeatureTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function checkIfBasicTestIsExecuted() : void
    {
        $this->assertTrue(true);
    }
}
