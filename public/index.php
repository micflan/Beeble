<?php

/* Import the autoloader and classes from external namespaces */
require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;


/* Define the routes for our application */

$request = HttpFoundation\Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';


// Load this thing!

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller = $resolver->getController($request);
    $arguments = $resolver->getArguments($request, $controller);

    $response = call_user_func_array($controller, $arguments);

} catch (Routing\Exception\ResourceNotFoundException $e) {
	$response = new HttpFoundation\Response('Not found', 404);
} catch (Exception $e) {
	$response = new HttpFoundation\Response('Error occurred<br/>'.$e->getMessage(), 500);
}

$response->send();
