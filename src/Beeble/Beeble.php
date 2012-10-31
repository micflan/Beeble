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

    public static function site_data($key = null) {
        $site_data = array(
            'page_title' => 'Welcome',
            'site_title' => 'My Website',
            'title_sep'  => ' || ',
            'asset_path' => '/assets/',
        );

        return $key ? (isset($site_data['key']) ? $site_data['key'] : null) : $site_data;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }


    public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }


    public static function render($view, $data)
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views');
        $twig = new \Twig_Environment($loader, array(
            'cache' => null,
            // __DIR__ . '/../../storage/twig/compilation_cache';
        ));

        $data = array_merge(self::site_data(), $data);

        return $twig->loadTemplate($view)->render($data);
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