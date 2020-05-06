<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestUser;

class ResetRequest extends RequestUser
{
	public function __construct()
	{
		$this->a_rule = [
			'email'					=> 'required|string|email|max:255|exists:users,email',
		];
	}
}
