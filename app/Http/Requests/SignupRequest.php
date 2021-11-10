<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestUser;

class SignupRequest extends RequestUser
{
	public function __construct()
	{
		$this->a_rule = [
			'email'						=> 'required|string|email|max:255|unique:users',
			'password'				=> 'required|string|min:6|max:40',
			'password_confirmation'	=> 'required|string',
			'first_name'			=> 'string|max:255',
			'last_name'				=> 'string|max:255',
		];
		if (config('app.env') != 'local')
		{
			$this->a_rule['g-recaptcha-response'] = 'required|recaptcha';
		}
	}
}
