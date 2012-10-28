<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;

class HelloController {

	public function indexAction($name)
	{
		return new Response("Hello $name");
	}
}

$routes = new RouteCollection();
$routes->add('hello', new Route(
	'/hello/{name}',
	array('name' => "World", '_controller' => 'HelloController::indexAction'))
);

return $routes;