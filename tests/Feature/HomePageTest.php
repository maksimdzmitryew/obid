<?php

namespace Tests\Feature;

use                                       Tests\TestCase;

class HomePageTest extends TestCase
{

    public function testTitle()
    {
        $response = $this->get('/');
        $response->assertSee('
    <title>
        FEATURE TEST
    </title>');
    }

    public function testVersionApp()
    {
        $a_version  = include( base_path(). '/version.php');
        $response = $this->get('/');
        $response->assertSee('<meta name="version-app" content="' . $a_version->app . '">');
    }

    public function testThemeName()
    {
        $a_modules = config('fragment.modules');
        $s_theme = lcfirst($a_modules[0]);

        $response = $this->get('/');
        $response->assertSee($s_theme);
    }

    public function testFunctionHideCookieDialog()
    {
        $response = $this->get('/');
        $response->assertSeeText('function hideCookieDialog()');
    }

    public function testVersionCss()
    {
        $a_version  = include( base_path(). '/version.php');
        $response = $this->get('/');
        $response->assertSee('.css?v=' . $a_version->css);
    }

    public function testVersionJs()
    {
        $a_version  = include( base_path(). '/version.php');
        $response = $this->get('/');
        $response->assertSee('.js?v=' . $a_version->js);
    }

}
