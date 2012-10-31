<?php

namespace Hello\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Hello\Model\User;

class HelloController extends BaseController {

	public function indexAction(Request $request, $name)
	{
		$data = array('name' => 'World', 'page_title' => 'Hello');
		
		$user = new User();
		if ( $user->is_valid_name($name) )
		{
			$data['name'] = $name;
			$data['page_title'] = $data['page_title'] . ' ' . $name;
		}

		return new Response(\Beeble\Beeble::render('hello.html', $data));
	}

}