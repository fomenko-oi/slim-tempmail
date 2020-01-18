<?php

namespace App\Http\Action\User\Mailbox;

use App\Http\ValidationException;
use App\Http\Validator\Validator;
use App\Model\User\Entity\UserProvider;
use App\Model\User\UseCase\Update\Command;
use App\Model\User\UseCase\Update\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DisplayCurrentEmailAction
{
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'success' => true,
            'data' => $this->userProvider->getEmail()
        ]);
    }
}
