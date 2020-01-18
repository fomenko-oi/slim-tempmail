<?php

namespace App\Http\Action\Main;

use App\Model\Email\Entity\MessageRepository;
use App\Model\User\Entity\UserProvider;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class MainPageAction
{
    /**
     * @var Environment
     */
    private Environment $view;
    /**
     * @var MessageRepository
     */
    private MessageRepository $messages;
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;

    public function __construct(Environment $view, MessageRepository $messages, UserProvider $userProvider)
    {
        $this->view = $view;
        $this->messages = $messages;
        $this->userProvider = $userProvider;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        list($receiver, $host) = explode('@', $this->userProvider->getEmail());

        return new HtmlResponse($this->view->render('app/index.html.twig', [
            'name'          => $request->getAttribute('name'),
            'messages'      => $messages = $this->messages->findByAddress($host, $receiver),
            'messagesCount' => count($messages)
        ]));
    }
}
