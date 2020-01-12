<?php

namespace App\Http\Action\Api\Domain;

use App\Http\ValidationException;
use App\Http\Validator\Validator;
use App\Model\Domain\UseCase\Create\Command;
use App\Model\Domain\UseCase\Create\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DomainStoreAction
{
    /**
     * @var Handler
     */
    private Handler $handler;
    /**
     * @var Validator
     */
    private Validator $validator;

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

        if ($errors = $this->validator->validate($command)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($command);

        return new JsonResponse([
            'success' => true
        ]);
    }
}
