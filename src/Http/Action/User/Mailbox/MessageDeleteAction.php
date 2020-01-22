<?php

namespace App\Http\Action\User\Mailbox;

use App\Model\Email\Entity\MessageRepository;
use App\Model\Email\UseCase\Remove\Command;
use App\Model\Email\UseCase\Remove\Handler;
use App\Model\User\Entity\UserProvider;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessageDeleteAction
{
    /**
     * @var Handler
     */
    private Handler $handler;
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;

    public function __construct(Handler $handler, UserProvider $userProvider)
    {
        $this->handler = $handler;
        $this->userProvider = $userProvider;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command();
        $command->messageId = $request->getAttribute('message');
        $command->inbox = $this->userProvider->getEmail();

        $this->handler->handle($command);

        return new JsonResponse(['success' => true]);
    }
}
