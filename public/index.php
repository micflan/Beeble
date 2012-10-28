<?php

/* Import the autoloader and classes from external namespaces */
require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;


/* Define the routes for our application */

$request = HttpFoundation\Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$framework = new Beeble\Framework($matcher, $resolver);
$response = $framework->handle($request);

$response->send();