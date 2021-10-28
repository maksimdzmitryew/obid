<?php

namespace Tests\Feature;

use                                    Tests\TestCase;

class XsrfTest extends TestCase
{
    /**
     * current session's CSRF token returned via the helper function
     *
     * @test
     * @return void
     */
    public function currentSessionCsrfTokenReturnedViaTheHelperFunction()
    {
        $response = $this->get('/refresh-csrf');
        $response->assertStatus(200);
        $response->assertCookie('XSRF-TOKEN');
    }
}
