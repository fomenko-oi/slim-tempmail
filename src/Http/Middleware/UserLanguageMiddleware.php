<?php

namespace App\Http\Middleware;

use App\Model\User\Service\Language\LanguageManager;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

class UserLanguageMiddleware implements MiddlewareInterface
{
    /**
     * @var LanguageManager
     */
    private LanguageManager $lang;

    public function __construct(LanguageManager $lang)
    {
        $this->lang = $lang;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $router = RouteContext::fromRequest($request);
        $urlLang = $router->getRoutingResults()->getRouteArguments()['lang'];

        if(!$urlLang || !$this->lang->available($urlLang)) {
            $available = $this->lang->detect($request);

            $routeParser = $router->getRouteParser();

            $url = $routeParser->urlFor($router->getRoute()->getName(), ['lang' => $available]);

            return new RedirectResponse($url);
        }

        $this->lang->set($urlLang);

        return $handler->handle($request);
    }
}
