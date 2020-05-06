<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestUser;

class SigninRequest extends RequestUser
{
	public function __construct()
	{
		$this->a_rule = [
			'email'					=> 'required|string|email|max:255',
			'g-recaptcha-response'	=> 'required|recaptcha',
			'password'				=> 'required|string|min:6',
			'login_safety'			=> 'nullable|integer',
		];
	}
}
