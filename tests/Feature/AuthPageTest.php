<?php

declare(strict_types=1);

namespace Tests\Feature;

use                                       Tests\TestCase;
use               Illuminate\Foundation\Testing\WithoutMiddleware;

class SigninPageTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * Webserver config is correct and signin page is opened
     *
     * @test
     * @return void
     */
    public function webserverConfigIsCorrectAndSigninPageIsOpened() : void
    {
        /**
         *  errors will be written to stdout instead of to page contents
         */
        $this->withoutExceptionHandling();

        $response = $this->get('/signin');
        $response->assertStatus(200);
    }

    /**
     * Title as meta is shown at Signin page
     *
     * @test
     * @return void
     */
    public function titleAsMetaIsShownAtSigninPage() : void
    {
        $response = $this->get('/signin');
        $response->assertSee('
    <title>
        ВХІД
 &#60;
        VIEWCOMPOSERSERVICEPROVIDER
    </title>');
    }

    /**
     * Signin form is shown with correct id at Signin page
     *
     * @test
     * @return void
     */
    public function signinFormIsShownWithCorrectIdAtSigninPage() : void
    {
        $response = $this->get('/signin');
        $response->assertSee('id="signin-form"');
    }

    /**
     * csrf-token is shown as meta at Signin page
     *
     * @test
     * @return void
     */
    public function csrfTokenIsShownAsMetaAtSigninPage() : void
    {
        $response = $this->get('/signin');
        $response->assertSee('<meta name="csrf-token" content="">');
    }

    /**
     * Signin form contains required elements: token, input, safety, submit
     *
     * @test
     * @return void
     */
    public function signinFormContainsRequiredElementsTokenInputSafetySubmit() : void
    {
        $response = $this->get('/signin');
        $response->assertSee('<input type="hidden" name="_token" value="">');
        $response->assertSee('<input type="text" name="email"');
        $response->assertSee('<input type="password" name="password"');
        $response->assertSee('value="0" checked="checked" id="login_safety_0"');
        $response->assertSeeText('Увійти');
    }

}
