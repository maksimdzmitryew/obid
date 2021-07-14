<?php

namespace Tests\Feature;

use                                    Tests\TestCase;
use            Illuminate\Foundation\Testing\WithoutMiddleware;

class SigninPageTest extends TestCase
{

	use WithoutMiddleware;

	public function testTitle()
	{
		$response = $this->get('/');
		$response->assertSee('<title>
		FEATURE TEST
	</title>');
	}

	public function testForm()
	{
		$response = $this->get('/signin');
		$response->assertSee('id="signin-form"');
	}

	public function testTokenMeta()
	{
		$response = $this->get('/signin');
		$response->assertSee('<meta name="csrf-token" content="">');
	}

	public function testTokenInput()
	{
		$response = $this->get('/signin');
		$response->assertSee('<input type="hidden" name="_token" value="">');
	}

	public function testLoginInput()
	{
		$response = $this->get('/signin');
		$response->assertSee('<input type="text" name="email"');
	}

	public function testPasswordInput()
	{
		$response = $this->get('/signin');
		$response->assertSee('<input type="password" name="password"');
	}

	public function testSafetyInput()
	{
		$response = $this->get('/signin');
		$response->assertSee('value="0" checked="checked" id="login_safety_0"');
	}

	public function testSubmitButton()
	{
		$response = $this->get('/signin');
		$response->assertSeeText('Увійти');
	}
}