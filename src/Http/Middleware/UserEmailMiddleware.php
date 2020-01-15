<?php

namespace App\Http\Middleware;

use App\Model\User\Entity\UserProvider;
use App\Model\User\Service\MailGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserEmailMiddleware implements MiddlewareInterface
{
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;
    /**
     * @var MailGenerator
     */
    private MailGenerator $mailGenerator;

    public function __construct(UserProvider $userProvider, MailGenerator $mailGenerator)
    {
        $this->userProvider = $userProvider;
        $this->mailGenerator = $mailGenerator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(!$this->userProvider->hasEmail()) {
            $this->userProvider->setEmail($this->mailGenerator->randomInbox());
        }

        return $handler->handle($request);
    }
}
