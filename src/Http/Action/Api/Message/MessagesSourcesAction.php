<?php

namespace App\Http\Action\Api\Message;

use App\Model\Email\UseCase\Source\Command;
use App\Model\Email\UseCase\Source\Handler;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessagesSourcesAction
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
        $command = new Command();
        $command->id = $request->getAttribute('id');

        return new TextResponse($this->handler->handle($command), 200);
    }
}
