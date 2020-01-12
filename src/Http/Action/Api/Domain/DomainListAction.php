<?php

namespace App\Http\Action\Api\Domain;

use App\Model\Domain\UseCase\Index\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DomainListAction
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
            'data' => $this->handler->handle()
        ]);
    }
}
