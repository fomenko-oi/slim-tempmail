<?php

namespace App\Http\Action\User\Cabinet;

use App\Model\Domain\Entity\DomainRepository;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class ChangeEmailAction
{
    /**
     * @var Environment
     */
    private Environment $view;
    /**
     * @var DomainRepository
     */
    private DomainRepository $domains;

    public function __construct(Environment $view, DomainRepository $domains)
    {
        $this->view = $view;
        $this->domains = $domains;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $domains = $this->domains->all();

        return new HtmlResponse($this->view->render('app/users/change_email.html.twig', ['domains' => $domains]));
    }
}
