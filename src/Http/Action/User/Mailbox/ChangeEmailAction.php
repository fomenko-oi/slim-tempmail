<?php

namespace App\Http\Action\User\Mailbox;

use App\Http\ValidationException;
use App\Http\Validator\Validator;
use App\Model\User\UseCase\Update\Command;
use App\Model\User\UseCase\Update\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChangeEmailAction
{
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var Handler
     */
    private Handler $handler;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();

        $command = new Command();
        $command->host = $params['host'] ?? null;
        $command->login = $params['login'] ?? null;

        if ($errors = $this->validator->validate($command)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($command);

        return new JsonResponse([
            'success' => true
        ]);
    }
}
