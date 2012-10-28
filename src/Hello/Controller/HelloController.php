<?php

namespace Hello\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Hello\Model\User;

class HelloController {

	public function indexAction(Request $request, $name)
	{
		$user = new User();
		if ( ! $user->is_valid_name($name))
		{
			return new Response("Not a valid name.");
		}

		return new Response("Hello $name");
	}
}