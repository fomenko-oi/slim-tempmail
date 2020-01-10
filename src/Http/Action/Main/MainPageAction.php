<?php

namespace App\Http\Action\Main;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\Route;
use Twig\Environment;

class MainPageAction
{
    /**
     * @var Environment
     */
    private Environment $view;

    public function __construct(Environment $view)
    {
        $this->view = $view;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        echo $this->view->render('app/layout.html.twig', ['name' => $request->getAttribute('name')]);

        die;
    }
}
