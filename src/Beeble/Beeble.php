<?php

namespace Beeble;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class Beeble
{
    protected $matcher;
    protected $resolver;

    public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }


    public static function twig()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views');

        return new \Twig_Environment($loader, array(
            // 'cache' => __DIR__ . '/../../storage/twig/compilation_cache',
        ));
    }

    public function handle(Request $request)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (\Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}