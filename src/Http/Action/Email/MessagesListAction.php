<?php

namespace App\Http\Action\Email;

use App\Service\Email\ReceiverService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessagesListAction
{
    /**
     * @var ReceiverService
     */
    private ReceiverService $service;

    public function __construct(ReceiverService $mailService)
    {
        $this->service = $mailService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        dd($this->service->getAllUnseenMessages());
    }
}
