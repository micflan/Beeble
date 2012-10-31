<?php

namespace Hello\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BaseController {

	protected $template;

	public function __construct()
	{
		$this->template = \Beeble\Beeble::twig()->loadTemplate('hello.html');
	}

}