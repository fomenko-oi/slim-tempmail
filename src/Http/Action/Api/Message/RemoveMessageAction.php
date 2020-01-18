<?php

namespace App\Http\Action\Api\Message;

use App\Http\ValidationException;
use App\Http\Validator\Validator;
use App\Model\Email\Entity\MessageRepository;
use App\Model\Email\UseCase\Remove\Command;
use App\Model\Email\UseCase\Remove\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveMessageAction
{
    /**
     * @var Handler
     */
    private Handler $handler;
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var MessageRepository
     */
    private MessageRepository $messageRepository;

    public function __construct(Handler $handler, Validator $validator, MessageRepository $messageRepository)
    {
        $this->handler = $handler;
        $this->validator = $validator;
        $this->messageRepository = $messageRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command();
        $command->inbox = $request->getAttribute('inbox');
        $command->messageId = $request->getAttribute('id');

        if($errors = $this->validator->validate($command)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($command);

        return new JsonResponse(['success' => true], 200);
    }
}
