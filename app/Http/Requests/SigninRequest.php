<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestUser;

class SigninRequest extends RequestUser
{
	public function __construct()
	{
		$this->a_rule = [
			'email'					=> 'required|string|email|max:255',
			'password'				=> 'required|string|min:6',
			'login_safety'			=> 'nullable|integer',
		];
		if (config('app.env') != 'local')
		{
			$this->a_rule['g-recaptcha-response'] = 'required|recaptcha';
		}
	}
}
