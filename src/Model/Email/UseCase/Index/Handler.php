<?php

namespace App\Model\Email\UseCase\Index;

use App\Model\Email\Entity\MessageRepository;

class Handler
{
    /**
     * @var MessageRepository
     */
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function handle(Command $command): array
    {
        list($login, $host) = explode('@', $command->email);

        return $this->messageRepository->findByAddress($host, $login);
    }
}
