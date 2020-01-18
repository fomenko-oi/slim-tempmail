<?php

namespace App\Http\Action\User\Mailbox;

use App\Model\Email\Entity\MessageRepository;
use App\Model\User\Entity\UserProvider;
use App\Model\User\Service\Language\LanguageManager;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class MessageDetailsAction
{
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;
    /**
     * @var MessageRepository
     */
    private MessageRepository $messages;
    /**
     * @var Environment
     */
    private Environment $view;
    /**
     * @var LanguageManager
     */
    private LanguageManager $languageManager;

    public function __construct(UserProvider $userProvider, MessageRepository $messages, Environment $view, LanguageManager $languageManager)
    {
        $this->languageManager = $languageManager;
        $this->userProvider = $userProvider;
        $this->messages = $messages;
        $this->view = $view;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $message = $this->messages->findById($request->getAttribute('message'));

        return new HtmlResponse($this->view->render('app/inbox/message.html.twig', [
            'message'   => $message,
            'lang'      => $this->languageManager->get()
        ]));
    }
}
