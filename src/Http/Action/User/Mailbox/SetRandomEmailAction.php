<?php

namespace App\Http\Action\User\Mailbox;

use App\Model\EMail\UseCase\Random\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SetRandomEmailAction
{
    /**
     * @var Handler
     */
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'success' => true,
            'data' => $this->handler->handle()
        ]);
    }
}
