<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection();
$routes->add('hello', new Route(
	'/hello/{name}',
	array('name' => "World", '_controller' => 'Hello\\Controller\\HelloController::indexAction'))
);

return $routes;