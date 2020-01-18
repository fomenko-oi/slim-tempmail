<?php

namespace App\Http\Action\User\Mailbox;

use App\Model\Email\Entity\MessageRepository;
use App\Model\User\Entity\UserProvider;
use App\Model\User\Service\Language\LanguageManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class MessagesListAction
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
        list($receiver, $host) = explode('@', $this->userProvider->getEmail());

        $html = $this->view->render('app/_partials/_email_messages.html.twig', [
            'messages'      => $messages = $this->messages->findByAddress($host, $receiver),
            'messagesCount' => count($messages),
            'lang'          => $this->languageManager->get()
        ]);

        return new JsonResponse([
            'success'   => true,
            'count'     => count($messages),
            'html'      => $html
        ]);
    }
}
