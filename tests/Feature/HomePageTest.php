<?php

declare(strict_types=1);

namespace Tests\Feature;

use                                       Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * Webserver config is correct and homepage is opened
     *
     * @test
     * @return void
     */
    public function webserverConfigIsCorrectAndHomePageIsOpened() : void
    {
        /**
         *  errors will be written to stdout instead of to page contents
         */
        $this->withoutExceptionHandling();

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Title as meta is shown at homepage
     *
     * @test
     * @return void
     */
    public function titleAsMetaIsShownAtHomepage() : void
    {
        $response = $this->get('/');
        $response->assertSee('
    <title>
        FEATURE TEST
    </title>');
    }

    /**
     * Version of app, css, js variables are read from config and passed to view
     *
     * @test
     * @return void
     */
    public function versionVariablesFromConfigIsPassedToView() : void
    {
        $a_version  = include( base_path(). '/version.php');
        $response = $this->get('/');
        $response->assertSee('<meta name="version-app" content="' . $a_version->app . '">');
        $response->assertSee('.css?v=' . $a_version->css);
        $response->assertSee('.js?v=' . $a_version->js);
    }

    /**
     * Theme title variable is read from config and passed to view
     *
     * @test
     * @return void
     */
    public function themeVariableFromConfigIsPassedToView() : void
    {
        $a_modules = config('fragment.modules');
        $s_theme = lcfirst($a_modules[0]);

        $response = $this->get('/');
        $response->assertSee($s_theme);
    }

    /**
     * Hide cookie dialog javascript function is present at homepage
     *
     * @test
     * @return void
     */
    public function hideCookieDialogJavascriptFunctionIsPresent() : void
    {
        $response = $this->get('/');
        $response->assertSeeText('function hideCookieDialog()');
    }
}
