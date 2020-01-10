<?php

namespace App\Http\Action\Email;

use App\Service\Email\MailService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessagesListAction
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
        dd($this->service->getAllUnseenMessages());
    }
}
