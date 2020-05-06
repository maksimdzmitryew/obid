<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestUser;

class SignupRequest extends RequestUser
{
	public function __construct()
	{
		$this->a_rule = [
			'email'					=> 'required|string|email|max:255|unique:users',
			'first_name'			=> 'string|max:255',
			'g-recaptcha-response'	=> 'required|recaptcha',
			'last_name'				=> 'string|max:255',
			'password'				=> 'required|string|min:6|confirmed',
			'password_confirmation'	=> 'required|string',
		];
	}
}
