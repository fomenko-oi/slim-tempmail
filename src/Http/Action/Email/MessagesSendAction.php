<?php

namespace App\Http\Action\Email;

use App\Service\Email\MailService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Slim\Routing\Route;
use Twig\Environment;

class MessagesSendAction
{
    /**
     * @var MailService
     */
    private MailService $service;

    public function __construct(MailService $mailService)
    {
        $this->service = $mailService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = $request->getAttribute('email');
        $text = $request->getQueryParams()['text'] ?? 'random text';

        $this->service->sendEmail($email, $text);

        return new Response();
    }
}
