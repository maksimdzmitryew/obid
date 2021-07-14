<?php

namespace Tests\Feature;

#use            Illuminate\Foundation\Testing\RefreshDatabase;
use                                    Tests\TestCase;
#use            Illuminate\Foundation\Testing\WithFaker;

class HomePageTest extends TestCase
{

	public function testTitle()
	{
		/**
		 *	errors will be written to stdout instead of to page contents
		 */
		$this->withoutExceptionHandling();

		$response = $this->get('/');
		$response->assertSee('<title>
		FEATURE TEST
	</title>');
	}

	public function testVersionApp()
	{
		$response = $this->get('/');
		$response->assertSee('version-app');
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
}